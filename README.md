ActiveReloader
===============

This is a `PHP` and `jQuery` based library that reloads page automatically as soon as you write new code or update existing code and save that particular file or whenever you add / remove some icon, image, css file from your project. The main goal of this library is to free web developers / designers from manually refreshing browser after making changes.

Manually refreshing browser again and again is a hassle. `ActiveReloader` will smoothly handle that part and you will see a huge difference in your productivity.

See following demo where browser is automatically getting refreshed to pick-up new changes as soon as user is saving the file.

![image](https://cloud.githubusercontent.com/assets/1183802/5170676/44e48988-7433-11e4-9f5f-5231ca17a5fb.gif)

## Configuration

You need both `PHP` and `jQuery` in-order to run this library smoothly. First download `active_reloader.php` and save it in your project's root path. Make sure you can access `active_reloader.php` at `http://your_server/your_project/active_reloader.php` or at whatever routing scheme you are using. Next download `active_reloader.js` and place it in your project at your preferred place (under `javascripts` folder maybe). Next include `active_reloader.js` in html by using popular `script` tag (make sure to include `script` tag for `active_reloader.js` after `jQuery` one). After that place following code in your html right after `script` tag for `active_reloader.js`.

	<script type="text/javascript">
		ActiveReloader.start({path: "http://{your_server}/{your_project}/active_reloader.php"});
	</script>
	
Please make sure to provide absolute HTTP path where you can access `active_reloader.php`. Now go-ahead refresh your browser for the very last time and if you have configured everything correctly your code changes will automatically trigger a change in browser's state and causing it to reload automatically. Yey!

### Configuration Options

Following are available configuration options.

**path** *required* - absolute path of `active_reloader.php`

**exclude_directories** *optional* - By-default `ActiveReloader` listens for changes in all files under all directories in your project root. You might want to exclude some directories and don't want to listen for their changes. You can use `exclude_directories` setting for this purpose. You need to pass directories in string form and can separate multiple directories with commas. For example:

	<script type="text/javascript">
		ActiveReloader.start({path: "http://{your_server}/{your_project}/active_reloader.php", exclude_directories: "application/logs, system"});
	</script>
	
In above code snippet `ActiveReloader` will not listen for changes in files under `application/logs` and `system` directories. Please make sure to provide relative paths according to your project's root in `exclude_directories` option.

**delay** *optional* - `ActiveReloader` sends request to listen for changes after 01 second when page loads for the very first time and then sends new requests periodically after 01 second on successful completion of former request. You can pass time in milliseconds to override this setting. For example:

	<script type="text/javascript">
		ActiveReloader.start({path: "http://{your_server}/{your_project}/active_reloader.php", delay: 2000});
	</script>
	
In above code snippet `ActiveReloader` will send new request to listen for changes in your project after 02 seconds on successful completion of former request.

## How it works?

`ActiveReloader` sends Ajax requests in a long-polling manner to `active_reloader.php` at regular intervals. Code in `active_reloader.php` checks for changes in files and return appropriate response in a long-polling way. Every request to `active_reloader.php` runs `loop` for `25 seconds` to see if some file is changed. If some file gets changed between those `25 seconds` response will be returned immediately to client. Long-polling removes need to send requests after each 01 second to listen for changes, thus not affecting your local server's performance by any means. You might be wondering why Ajax requests when there are better ways to do this like WebSockets, Server-Sent Events etc.?

Server-Sent Events are quite efficient than Ajax requests as they establish a single long-lived HTTP connection and there is no need for client to establish new connections. But it also requires some extra effort to write code and sends response in a particular format. It also requires use of `ob_flush` and `flush` which might not be acceptable to you because of your application's setting.

WebSockets on the other hand requires Evented Server which itself is a quite hectic task when it comes to integrate it with PHP on Windows.

So I decided to use Ajax long-polling because it's a simple and reliable mechanism and doesn't require any extra effort. Plus you are only using it locally while you are developing so it is not going to hurt performance.

## Beware

Don't push `active_reloader.php` and `active_reloader.js` and it's configuration code to your production server in any case. This library is only intended to be used locally during development process.

## Contributing

1. Fork
2. Test
3. Report issues
4. Submit Pull Requests

**Please don't forget to `Star` this repo if you find this helpful and share it with your friends too.**
