<div>
    <div class="table-responsive p-0" style="max-height: 50vh; min-height: 50vh;">
        <div class="row sticky-top bg-white">
            <div class="col">
                <div class="p-1 ps-2 pe-2 mb-1">
                    <input wire:model='searchedTag' wire:keydown='SearchTag' type="text"
                        class="form-control bg-white border-dark-subtle" placeholder="Enter tag name ...">
                </div>
            </div>
        </div>
        <table wire:loading.attr='hidden' class="table table-hover bg-white">
            <tbody>
                @if (empty($TagsList) == false)
                @foreach ($TagsList as $tag)
                <tr wire:key='assignTag_{{$tag->id}}'>
                    <button wire:click='AssignTag({{$tag->id}})' type="submit" id="assignTag_{{$tag->id}}" class="selectTagBtn dropdown-item">
                        {{$tag->name}}
                    </button>
                </tr>
                @endforeach
                @else
                <tr>
                    <div class="d-flex justify-content-start mt-1">
                        <button wire:click='AddTag' id="addTagBtn" class="selectTagBtn dropdown-item text-success">+ Add Tag</button>
                    </div>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
    <style>
        .selectTagBtn:hover, .selectTagBtn:focus {
            background: rgb(232, 232, 232);
            color: black;
        }
    </style>
</div>