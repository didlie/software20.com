<?php

        require_once("views/view.php");
        view::set_view(isset($_GET['content'])? 1 : (isset($_GET['employment'])? 3 : 0));

?><html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Software 2.0</title>
    <style><?php

            echo file_get_contents("3p.css");
            echo file_get_contents("css/software20.css");

    ?></style>
</head>
<body>
    <div id='_3p-right' class="_3p-right-arrow">&raquo;</div>
    <div id="_3p-left" class="_3p-left-arrow">&laquo;</div>
    <div id="_3p-header"></div>
    <div id="body"><div id="_3p-left-body" class="_3p-div"><?php

                echo view::p1();

        ?></div><div id="_3p-center-body" class="_3p-div"><?php

                echo view::p2();

        ?></div><div id="_3p-right-body" class="_3p-div"><?php

                echo view::p3();

        ?></div>
    </div>
    <script><?php

                echo file_get_contents("3p-min.js");

    ?></script>
    <div id="_3p-footer">Software 2.0 (c) 2013 - Present</div>
</body>
</html>
