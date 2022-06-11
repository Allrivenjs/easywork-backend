require('./bootstrap');
Echo.listen('MessageNotification', function(data) {
    alert(JSON.stringify(data));
});
