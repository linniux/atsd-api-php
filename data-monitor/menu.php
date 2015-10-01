<form>
<table id="menu" border="1px" class="table-striped table-bordered table-condensed midtable">
    <tr class="table-head">
        <th>Entity Group</th>
        <th>Time Lag ( min )</th>
        <th>Time Ahead ( min )</th>
        <th>Filter</th>
    </tr>
    <tr>
        <td>
            <select name="group" class="form-control" onchange="this.form.submit()">
                <option value="">select group</option>
                <?php
                foreach ($groups as $group) {
                    $groupName = htmlspecialchars($group["name"]);
                    echo '<option value="' . $groupName . ((!empty($_REQUEST['group']) && $_REQUEST['group'] == $groupName) ? '" selected' : '"') . ">" . $groupName . "</option>";
                }
                ?>
            </select>
        </td>
        <td>
            <select name="lag" class="time-select form-control">
                <?php
                for ($i = 0; $i <= 15; $i++) {
                    echo "<option value='" . $i . ((isset($_REQUEST['lag']) && $_REQUEST['lag'] == $i) ? "' selected" : "'") . ">" . $i . "</option>";
                }
                ?>
            </select>
        </td>
        <td>
            <select name="ahead" class="time-select form-control">
                <?php
                for ($i = 0; $i <= 15; $i++) {
                    echo "<option value='" . $i . ((isset($_REQUEST['ahead']) && $_REQUEST['ahead'] == $i) ? "' selected" : "'") . ">" . $i . "</option>";
                }
                ?>
            </select>
        </td>
        <td>
            <select name="filter" class="filter-select form-control">
                <option value="all" <?=$_REQUEST['filter'] == 'all'?"selected":""?>>all</option>
                <option value="lagging" <?=$_REQUEST['filter'] == 'lagging'?"selected":""?> class="lagging">lagging</option>
                <option value="ahead" <?=$_REQUEST['filter'] == 'ahead'?"selected":""?> class="ahead">ahead</option>

            </select>
        </td>
    </tr>
</table>
</form>
<div id="timezone">
    All times specified in <b><?=date_default_timezone_get()?></b>
</div>