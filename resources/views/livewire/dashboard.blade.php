<div class="container-fluid px-4 pt-4">
  <div class="row g-4">
    <div class="col-sm-6 col-xl-3">
      <div class="bg-secondary d-flex align-items-center justify-content-between rounded p-4">
        <i class="fa fa-users fa-3x text-primary"></i>
        <div class="ms-3">
          <p class="mb-2">Total Students</p>
          <h6 class="mb-0">{{ $total_students }}</h6>
        </div>
      </div>
    </div>
    <div class="col-sm-6 col-xl-3">
      <div class="bg-secondary d-flex align-items-center justify-content-between rounded p-4">
        <i class="fa fa-school fa-3x text-primary"></i>
        <div class="ms-3">
          <p class="mb-2">Total Class</p>
          <h6 class="mb-0">{{ $total_class }}</h6>
        </div>
      </div>
    </div>
  </div>

  <!-- Recent Students Table -->
  <div class="h-100 bg-secondary mt-3 rounded p-4">
    <div class="h2">
      <h4>Recent Students</h4>
    </div>
    <div class="table-responsive">
      <table class="table-striped table">
        <thead>
          <tr>
            <th>Name</th>
            <th>Phone</th>
            <th>Class</th>
            <th>Gender</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($recent_students as $student)
            <tr>
              <td>{{ $student->first_name }} {{ $student->last_name }}</td>
              <td>{{ $student->phone_number }}</td>
              <td>{{ $student->school_class_id }}</td>
              <td>{{ $student->gender }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>

  <!-- School Update Section -->
  <div class="h-100 bg-secondary mt-3 rounded p-4">
    <div class="card-header">
      <h4>Update School Information</h4>
    </div>
    <div class="card-body">
      <input class="form-control mb-2" type="text" wire:model="school_name" placeholder="School Name">
      <input class="form-control mb-2" type="text" wire:model="school_address" placeholder="School Address">
      <button class="btn btn-primary" wire:click="updateSchool">Update</button>
    </div>
  </div>

  <!-- User Profile Update Section -->
  <div class="h-100 bg-secondary mt-3 rounded p-4">
    <div class="card-header">
      <h4>Update Profile</h4>
    </div>
    <div class="card-body">
      <input class="form-control mb-2" type="text" wire:model="name" placeholder="Name">
      <input class="form-control mb-2" type="email" wire:model="email" placeholder="Email">
      <input class="form-control mb-2" type="text" wire:model="phone" placeholder="Phone Number">
      <button class="btn btn-success" wire:click="updateProfile">Update</button>
    </div>
  </div>

  <!-- Flash Messages -->
  @if (session()->has('message'))
    <div class="alert alert-success mt-3">{{ session('message') }}</div>
  @endif
</div>
