<html>
{{HEAD}}
<body>
{{HEADER}}
<h2>register</h2>
<span>
    <form id="register_form">
        <input name="email" type="email" placeholder="email-address" required>
        <input name="pass" type="password" placeholder="password" pattern=".{11,}" oninvalid="this.setCustomValidity('The password must be at least 12 characters long.')">
        <input name="pass_repeat" type="password" placeholder="repeat password" pattern=".{11,}" oninvalid="this.setCustomValidity('The password must be at least 12 characters long.')">
        <input type="submit" value="register">
    </form>
    <script type="text/javascript">
        $(document).ready(function(){
            var form = $('#register_form');
            form.on('submit', function(e){
                e.preventDefault();
                var pass_input = $('[name=pass]')[0];
                var pass = pass_input.value;
                var pass_repeat_input = $('[name=pass_repeat]')[0];
                var pass_repeat = pass_repeat_input.value;
                if(pass !== pass_repeat) {
                    pass_repeat_input.setCustomValidity("The passwords must be the same.");
                }else if(pass.length < 12){
                    pass_input.setCustomValidity("The password must be at least 12 characters long.")
                }else if(pass_repeat.length < 12) {
                    pass_repeat_input.setCustomValidity("The password must be at least 12 characters long.")
                }else{
                    pass_input.setCustomValidity("");
                    pass_repeat_input.setCustomValidity("");
                    $.ajax({
                        url : '/user/new',
                        data : form.serialize(),
                        method: 'POST',
                        success: function(response){
                            if(response == 'ok'){
                                window.location.href = '/login'
                            }else{
                                alert(response);
                            }
                        }
                    });
                }
            });
        });
    </script>
</span>
</body>
</html>