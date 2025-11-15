<div class="row mb-4 justify-content-between">
    <div class="col-auto">
        {{-- Select --}}
        @inject('Boms', App\Models\Bom::class)
        <div class="input-group input-group-sm">
            <span class="input-group-text text-white fw-bold" style="background: #3e5877;">Select a BOM</span>
            <select wire:change='ViewQuotations' wire:model='selectedBomId' name="selectedBom" id="selectedBom" class="form-select bg-white border-dark-subtle">
                <option value=""></option>
                @foreach ($Boms::where('status', 'published')->orWhere('status', 'closed')->get() as $bom)
                <option value="{{$bom->id}}">#{{$bom->id}} - {{$bom->subject}}</option>
                @endforeach
            </select>
        </div>
    </div>
    @if (!empty($selectedBomId))
    <div class="col-auto">
        {{-- Search --}}
        <div class="input-group input-group-sm">
            <span class="input-group-text text-white fw-bold" style="background: #3e5877;">Sort Price</span>
            <select wire:change='ChangeOrderBy' wire:model='orderBy' name="orderBy" id="orderBy" class="form-select bg-white border-dark-subtle">
                <option value="asc">Ascending</option>
                <option value="desc">Descending</option>
            </select>
        </div>
    </div>        
    @endif
</div>
