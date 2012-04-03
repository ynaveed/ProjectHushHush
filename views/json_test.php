<html>
    <head>
        <script src="//ajax.googleapis.com/ajax/libs/dojo/1.7.2/dojo/dojo.js"></script>
        <script>
            function test(){
                //var json = '<?php // echo $json; ?>';
                
                console.log(dojox.json.query("foo",{foo:"bar"}));
                
            }
        </script>
    </head>
    <body>
        <input type="button" onclick="test();" />
    </body>
</html>