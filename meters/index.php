<?php require_once (dirname(__FILE__)) . '/Request.php';
$request = new Request();
$title = "Meter Report";
?>
<?php include_once("./header.php")?>
<table>
    <tbody>
       <?php include_once("./menu.php")?>
       <td>
           <div>
               <table style="width:100%">
                   <tbody>
                        <tr>
                            <td><div class="widget-chart-0 widget"></div></td>
                            <td><div class="widget-text-0 widget"></div></td>
                        </tr>
                        <tr>
                            <td colspan="2"><div class="widget-chart-1 widget"></div></td>
                        </tr>
                   </tbody>
               </table>
           </div>
       </td>
    </tr>
    <?php if($request->getSelectedEntity()) :?>
        <tr>
            <td></td>
            <td>
                <div>
                    <h4>Daily Reports:</h4>
                    <?php for($i = 0; $i < 7; $i++) :?>
                        <a href="javascript:getReport('<?=$request->getSelectedEntity()?>','<?=$request->formatEndTime("day", $i, $view = false)?>','1-DAY')"><?=$request->formatEndTime('day', $i, $view = true)?></a></br>
                    <?php endfor;?>
                </div>
                <div>
                    <h4>Weekly Reports:</h4>
                    <?php for($i = 0; $i < 4; $i++) :?>
                        <a href="javascript:getReport('<?=$request->getSelectedEntity()?>','<?=$request->formatEndTime("week", $i, $view = false)?>','1-WEEK')"><?=$request->formatEndTime('week', $i, $view = true)?></a></br>
                    <?php endfor;?>
                </div>
                <div>
                    <h4>Monthly Reports:</h4>
                    <?php for($i = 0; $i < 3; $i++) :?>
                        <a href="javascript:getReport('<?=$request->getSelectedEntity()?>','<?=$request->formatEndTime("month", $i, $view = false)?>','1-MONTH')"><?=$request->formatEndTime('month', $i, $view = true)?></a></br>
                    <?php endfor;?>
                </div>
            </td>
        </tr>
    <?php endif;?>
    </tbody>
</table>
<script>
    function onBodyLoad(){
        generateWidgets("<?=$request->getSelectedEntity()?>");
        resizeWidgets("<?=$request->getSelectedEntity()?>");
    }
</script>
</body>
</html>