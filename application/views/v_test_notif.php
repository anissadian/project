<html>
    <body>
        <div id="token"></div>
        <div id="msg"></div>
        <div id="notis"></div>
        <div id="err"></div>
        <script>
            MsgElem = document.getElementById("msg");
            TokenElem = document.getElementById("token");
            ErrElem = document.getElementById("err");
            NotisElem = document.getElementById("notis");
        </script>
    </body>

    <script>
        var config = {
            messagingSenderId: '637967445990'
        };
        firebase.initializeApp(config);
    </script>
</html>