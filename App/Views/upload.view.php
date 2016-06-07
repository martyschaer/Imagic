<html>
{{HEAD}}
<body>
{{HEADER}}
<div class="content">
    <h2>upload new picture</h2>
    <div class="form">
        <form>
            <br>
            <table>
                <tr>
                    <td><input id="file_container" type="file" placeholder="choose image"></td>
                    <td><input id="tags" type="text" placeholder="tags(space separated)"></td>
                    <td><input id="title" type="text" placeholder="title"></td>
                    <td>
                        <button id="submit_image" class="submit">upload</button>
                    </td>
                </tr>
                <tr>
                <td colspan="2">
                        <div id="feedback" class="feedback">

                        </div>
                    </td>
                </tr>
            </table>
        </form>
    </div>
    <script>
        $(document).ready(function () {
            $('button#submit_image').on('click', function (e) {
                e.preventDefault();
                console.log("press");
                var file = $('input#file_container').prop('files')[0];
                var user_feedback = $('div#feedback');
                var data = new FormData();
                data.append('file', file);
                data.append('tags', $('input#tags').val());
                data.append('title', $('input#title').val());
                if(file == undefined){
                    user_feedback.html('no file chosen');
                    return;
                }
                $.ajax({
                    url         : '/images',
                    dataType    : 'text',
                    cache       : false,
                    contentType : false,
                    processData : false,
                    data        : data,
                    type        : 'POST',
                    success     : function(response){
                        if(response === 'ok'){
                            window.location.replace('/');
                        }
                    }
                })
            });
        });
    </script>
</div>
</body>
</html>