<?php

namespace App\Traits;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

trait FileTrait
{
    protected mixed $file;

    /**
     * @param  string  $type
     * @param  string  $path
     * @return mixed
     *
     * @throws Throwable
     */
    public function getImages(string $type, string $path): mixed
    {
        match ($type) {
            'public', 'private' => $this->getFile($type, $path),
            default => abort(Response::HTTP_NOT_FOUND, 'File type is not supported'),
        };

        return $this->file;
    }

    /**
     * @throws Throwable
     */
    private function getFile(string $type, string $path): void
    {

        self::authorize($type);
        $storage = Storage::disk($type);
        abort_if(! $storage->exists($path), Response::HTTP_NOT_FOUND, 'File not found');
        $this->file = ($storage->response($path));
    }

    /**
     * @throws AuthorizationException
     */
    public function uploadFile(string $type, $file, string $name): string|bool
    {
        self::authorize($type);

        return str_replace($type.'/', '', Storage::putFileAs($type, $file, $name));
    }

    /**
     * @throws AuthorizationException
     */
    public function httpResponse(Request $request): Response
    {
        $request->validate($this->rules());

        return response()->json([
            'message' => 'File uploaded successfully',
            'file_name' => $this->uploadFile($request->input('type'), $request->file('file'), $request->file('file')->getClientOriginalName()),
            'type' => $request->input('type'),
        ]);
    }

    private function rules(): array
    {
        return [
            'file' => 'required|file|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'type' => 'required|string|in:public,private',
        ];
    }
}
