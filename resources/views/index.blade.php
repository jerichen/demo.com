<html>
    <head>
        <title>UpdateDemo</title>
    </head>
    <body>
        <form action="{{env('APP_URL')}}/update/post" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}

            Select image to upload:
            <input type="file" name="fileToUpload" id="fileToUpload">
            <input type="submit" value="Upload Image" name="submit">
        </form>
    </body>
</html>
