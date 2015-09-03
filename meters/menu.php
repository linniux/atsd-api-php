<?php if(empty($_SESSION['entities'])):?>
    <tr>
    No entities found for current user. <?exit()?>
    </tr>
<?php else :?>
    <tr>
        <td style="padding-top: 10px">Meters:</td>
        <td></td>
    </tr>
    <tr>
    <td id="menu" style="padding-top: 10px; padding-right: 20px" valign="top">
        <form method="POST" action="index.php" style="white-space: nowrap">
            <?php foreach($_SESSION['entities'] as $entity): ?>
                <input type="radio" <?=($request->getSelectedEntity() == $entity)?"checked":""?>
                       name="entity" value="<?=htmlspecialchars($entity)?>" id="<?=htmlspecialchars($entity) ?>" onchange="this.form.submit()">
                <label for="<?=htmlspecialchars($entity)?>"><?=htmlspecialchars($entity)?></label></br>
            <?php endforeach; ?>
        </form>
        <form method="POST" action="summary.php" style="padding-top: 20px">
            <input type="hidden" value="false" id="summary" name="summary"/>
            <input type="button" value="Summary" onclick="document.getElementById('summary').value = true; this.form.submit()"/>
        </form>
    </td>
<?php endif?>