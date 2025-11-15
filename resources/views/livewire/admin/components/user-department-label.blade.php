<div wire:poll.5s>
    @inject('Departments', App\Models\Department::class)
    @inject('UserDepartments', App\Models\UserDepartment::class)
    @if (count($UserDepartments::where('user_id', Auth::user()->id)->get()) > 0)
        @foreach ($UserDepartments::where('user_id', Auth::user()->id)->get() as $userDepartment)
            @foreach ($Departments::where('id', $userDepartment->department_id)->get() as $department)
            <span>{{$department->name}}</span>
            @endforeach
        @endforeach
    @else
        <span>No Department Set</span>
    @endif
</div>
