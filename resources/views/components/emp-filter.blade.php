<aside>
    <h5>All Filters</h5>
    <div class="filter">
        <h5>Industry</h5>
        @php
            $checkedIndustries = explode(',', request()->industry);
        @endphp
        <ul style="display:{{ !empty($checkedIndustries) ? 'block' : 'none' }};">

            @forelse ($industries as $key => $value)
                <li class="checkbox"><label><input type="checkbox" name="industry[]"
                            {{ in_array($value->id, $checkedIndustries) ? 'checked' : '' }} class="industry"
                            value="{{ $value->id }}" class="form-input"
                            id="{{ $key }}">{{ $value->name }}</label></li>
            @empty
            @endforelse

        </ul>
    </div>
    {{-- <div class="filter">
        <h5>Work mode</h5>
        <ul>
            <li class="checkbox"><label><input type="checkbox" name="" class="form-input" id="">Work from office</label></li>
            <li class="checkbox"><label><input type="checkbox" name="" class="form-input" id="">Remote</label></li>
            <li class="checkbox"><label><input type="checkbox" name="" class="form-input" id="">Hybrid</label></li>
        </ul>
    </div>
    <div class="filter">
        <h5>Salary</h5>
        <input type="range" name="" class="form-input" id="">
    </div>
    <div class="filter">
        <h5>Role</h5>
        <ul>
            <li class="checkbox"><label><input type="checkbox" name="" class="form-input" id="">Software Development</label></li>
            <li class="checkbox"><label><input type="checkbox" name="" class="form-input" id="">Content Management</label></li>
            <li class="checkbox"><label><input type="checkbox" name="" class="form-input" id="">Quality Assurance and Testing</label></li>
            <li class="checkbox"><label><input type="checkbox" name="" class="form-input" id="">Graphic Designing</label></li>
            <li class="checkbox"><label><input type="checkbox" name="" class="form-input" id="">Other Design</label></li>
        </ul>
    </div> --}}
</aside>
