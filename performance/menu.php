
<?php if(!isset($_SESSION['entities']) || empty($_SESSION['entities'])):?>
    No entities found for current user. <?php exit()?>
<?php else :?>
    <div class="menuBlocks" id="menu">
        <form method="GET" id="form">
            <select name='entity'  style="height: 600px; width: 200px;" onchange="this.form.submit()" class="selectpicker" multiple="multiple">
                <?php foreach($_SESSION['entities'] as $entity): ?>
                    <option
                        value="<?=htmlspecialchars($entity)?>"
                        <?=($request->selectedEntity == $entity)?'selected="selected"':''?>">
                        <?=htmlspecialchars($entity)?>
                    </option>
                <?php endforeach; ?>
            </select>
            <input type="hidden" name="tab" id="tabField" value="<?=$currentTab;?>"/>
        </form>
    </div>
<?php endif?>
