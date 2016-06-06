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
        <form>
            <table>
                <tr>
                    <td>
                        email
                    </td>
                    <td>
                        <input type="email" placeholder="{{email}}">
                    </td>
                </tr>
                <tr>
                    <td>member since</td>
                    <td>{{signup}}</td>
                </tr>
                <tr>
                    <td>username</td>
                    <td>
                        <input type="text" placeholder="{{username}}">
                    </td>
                </tr>
                <tr>
                    <td>permission level</td>
                    <td>{{permission}}</td>
                </tr>
                <tr>
                    <td><a href="/users/picture">change profile picture</a></td>
                </tr>
            </table>
        </form>
    </div>
    <div class="form">
        <div class="danger">
            danger zone
        </div>
        <form>
            <table width="90%">
                <tr>
                    <td>
                        deleting your account will get rid of all your data
                    </td>
                    <td>
                        <button class="danger" id="delete_account_button">delete account</button>
                    </td>
                </tr>
            </table>
        </form>
        <script>

        </script>
    </div>
</div>
</body>
</html>