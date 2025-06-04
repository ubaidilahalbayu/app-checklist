<div>
    <input type="checkbox" wire:model="checked" wire:change="" value="item1"> Item 1<br>
    <input type="checkbox" wire:model="checked" wire:change="processMa()" value="item2"> Item 2<br>

    <pre>{{ json_encode($checked) }}</pre>
</div>
