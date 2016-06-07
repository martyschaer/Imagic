<html>
{{HEAD}}
<body>
{{HEADER}}
<div class="content">
    <h2>profile</h2>
    <img class="profile_picture" src="{{RESOURCE_PATH}}/images/full/{{profile_image}}" title="{{profile_image}}">
    <br>
    <span>welcome to this super cool profile</span>
    <br>
    <br>
    <div class="form">
        <form id="details">
            <table>
                <tr>
                    <td>
                        email
                    </td>
                    <td>
                        <input name="email" type="email" placeholder="{{email}}">
                    </td>
                </tr>
                <tr>
                    <td>member since</td>
                    <td>{{signup}}</td>
                </tr>
                <tr>
                    <td>username</td>
                    <td>
                        <input name="username" type="text" placeholder="{{username}}">
                    </td>
                </tr>
                <tr>
                    <td>permission level</td>
                    <td>{{permission}}</td>
                </tr>
                <tr>
                    <td><a href="/users/picture">change profile picture</a></td>
                </tr>
                <tr>
                    <td>
                        <button id="change_details" class="submit">change account details</button>
                    </td>
                </tr>
            </table>
        </form>
    </div>
    <div class="form">
        <div class="danger">
            danger zone
        </div>
        <table width="90%">
            <tr>
                <td>
                    deleting your account will get rid of all your data
                </td>
                <td>
                    <button class="danger" id="delete_account">delete account</button>
                </td>
            </tr>
        </table>
        <br>
        <script>
            $(document).ready(function () {
                $('button#change_details').on('click', function(e){
                    e.preventDefault();
                    $.ajax({
                        type    : 'PATCH',
                        url     : '/users/{{id}}',
                        data    : $('form#details').serialize(),
                        success : function(r){
                            window.location.reload();
                        }
                    });
                });

                //delete account
                $('button#delete_account').on('click', function (e) {
                    e.preventDefault();
                    if (confirm("Do you really want to delete your account?")) {
                        if (confirm("are you absolutely definitely sure?")) {
                            $.ajax({
                                type: 'DELETE',
                                url: '/users/{{id}}',
                                success: function (r) {
                                    window.location.replace('/');
                                }
                            });
                        }
                    }
                });
            })
        </script>
    </div>
</div>
</body>
</html>