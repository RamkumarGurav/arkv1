
    <script type="text/javascript">

    var i = 0;

    function incNumber() {
        if (i < 10) {
            i++;
        } else if (i = 10) {
            i = 0;
        }
        document.getElementById("display").innerHTML = i;
    }

    function decNumber() {
        if (i > 0) {
            --i;
        } else if (i = 0) {
            i = 10;
        }
        document.getElementById("display").innerHTML = i;
    }
    </script>