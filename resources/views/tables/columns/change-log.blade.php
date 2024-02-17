<div class="text-xs">
    <div class="py-2 grid" style="grid-template-columns: 1fr repeat(2, 200px); gap: 0px 10px;">
        <div class="font-bold" style="min-width: 100px;">Field</div>
        <div class="font-bold">Old Value</div>
        <div class="font-bold">New Value</div>
        @foreach ($getState() as $change)
            <div class="font-bold" style="min-width: 100px;">{{ $change['field'] }}</div>
            <div class="" style="overflow: hidden; text-overflow: ellipsis;">{{ $change['prev'] }}</div>
            <div class="" style="overflow: hidden; text-overflow: ellipsis;">{{ $change['new'] }}</div>
        @endforeach
    </div>
</div>
