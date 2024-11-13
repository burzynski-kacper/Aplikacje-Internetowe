<?php
/** @var $fish ?\App\Model\Fish */
?>

<div class="form-group">
    <label for="species">Species</label>
    <input type="text" id="species" name="fish[species]" value="<?= $fish ? $fish->getSpecies() : '' ?>">
</div>

<div class="form-group">
    <label for="location">Location</label>
    <input type="text" id="location" name="fish[location]" value="<?= $fish ? $fish->getLocation() : '' ?>">
</div>

<div class="form-group">
    <label for="record">Record</label>
    <input type="text" id="record" name="fish[record]" value="<?= $fish ? $fish->getRecord() : '' ?>">
</div>

<div class="form-group">
    <input type="submit" value="Submit">
</div>
