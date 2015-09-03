<?php require_once (dirname(__FILE__)) . '/Request.php';
$request = new Request();
$title = "Summary Report"
?>
<?php include_once("./header.php")?>
<table>
    <tbody>
    <?php include_once("./menu.php");?>
       <td>
           <div>
               <table style="width:100%">
                   <tbody>
                        <tr>
                            <td colspan="2"><div class="widget-chart-2 widget"></div></td>
                        </tr>
                   </tbody>
               </table>
           </div>
       </td>
    </tr>
    </tbody>
</table>
<script>
    function onBodyLoad(){
        generateSummary();
        resizeSummary();
    }
</script>

</body>
</html>