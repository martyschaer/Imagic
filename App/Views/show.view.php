<html>
{{HEAD}}
<body>
{{HEADER}}
<div class="content">
    your images:
    <div id="images">

    </div>

    <script>
        $(document).ready(function(){
            var images = JSON.parse('{{JSON}}');
            for(var i = 0; i < images.length; i++){
                var image = images[i];
                $('div#images').append("<img class='showimage' src='/resources/images/full/" + image.file_id + "'>");
            }
        });
    </script>
</div>
</body>
</html>