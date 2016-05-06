<html>
{{HEAD}}
<body>
<h1>register</h1>
<span>
    <form id="register_form" onsubmit="validate(event);">
        <input name="email" type="email" placeholder="email-address" required>
        <input name="pass" type="password" placeholder="password" pattern=".{11,}" oninvalid="this.setCustomValidity('The password must be at least 12 characters long.')">
        <input name="pass_repeat" type="password" placeholder="repeat password" pattern=".{11,}" oninvalid="this.setCustomValidity('The password must be at least 12 characters long.')">
        <input type="submit" value="register">
    </form>
    <script type="text/javascript">
        function validate(e){
            e.preventDefault();
            alert("adf");
            var form = document.getElementById("register_form");
        }
    </script>
</span>
</body>
</html>