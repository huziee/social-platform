@php
    $user = Auth::user();
@endphp

<div class="card">
    <!-- Card header START -->
    <div class="card-header border-0 pb-0 d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Profile Info</h5>
        <button type="button" id="aboutEditBtn" class="btn btn-sm btn-primary">
            Edit
        </button>
    </div>
    <!-- Card header END -->
    <!-- Card body START -->
    <div class="card-body">
        <form id="aboutForm">
            <div class="rounded border px-3 py-2 mb-3">
                <h6 class="mb-2">Overview</h6>
                <p class="mb-0" id="aboutDescriptionText">
                    {{ $user->description ?: 'No bio added yet. Tell people a bit about yourself.' }}
                </p>
                <textarea class="form-control d-none mt-2" id="aboutDescriptionInput" name="description"
                    rows="3"
                    placeholder="Tell people a bit about yourself...">{{ $user->description }}</textarea>
            </div>

        <div class="row g-4">
            <div class="col-sm-6">
                <!-- Birthday START -->
                <div class="d-flex align-items-center rounded border px-3 py-2">
                    <div class="w-100">
                        <p class="mb-1">
                            <i class="bi bi-calendar-date fa-fw me-2"></i>
                            Born:
                            <strong id="aboutDobText">
                                {{ $user->date_of_birth ? \Carbon\Carbon::parse($user->date_of_birth)->format('F d, Y') : 'Not specified' }}
                            </strong>
                        </p>
                        <input type="date" class="form-control d-none" id="aboutDobInput" name="date_of_birth"
                            value="{{ $user->date_of_birth }}">
                    </div>
                </div>
                <!-- Birthday END -->
            </div>

            <div class="col-sm-6">
                <!-- Phone START -->
                <div class="d-flex align-items-center rounded border px-3 py-2">
                    <div class="w-100">
                        <p class="mb-1">
                            <i class="bi bi-telephone fa-fw me-2"></i>
                            Phone:
                            <strong id="aboutPhoneText">{{ $user->phone_number ?: 'Not provided' }}</strong>
                        </p>
                        <input type="text" class="form-control d-none" id="aboutPhoneInput" name="phone_number"
                            value="{{ $user->phone_number }}">
                    </div>
                </div>
                <!-- Phone END -->
            </div>

            <div class="col-sm-6">
                <!-- First name START -->
                <div class="d-flex align-items-center rounded border px-3 py-2">
                    <div class="w-100">
                        <p class="mb-1">
                            <i class="bi bi-person fa-fw me-2"></i>
                            First name:
                            <strong id="aboutFirstNameText">{{ $user->first_name }}</strong>
                        </p>
                        <input type="text" class="form-control d-none" id="aboutFirstNameInput" name="first_name"
                            placeholder="First name" value="{{ $user->first_name }}">
                    </div>
                </div>
                <!-- First name END -->
            </div>

            <div class="col-sm-6">
                <!-- Last name START -->
                <div class="d-flex align-items-center rounded border px-3 py-2">
                    <div class="w-100">
                        <p class="mb-1">
                            <i class="bi bi-person fa-fw me-2"></i>
                            Last name:
                            <strong id="aboutLastNameText">{{ $user->last_name }}</strong>
                        </p>
                        <input type="text" class="form-control d-none" id="aboutLastNameInput" name="last_name"
                            placeholder="Last name" value="{{ $user->last_name }}">
                    </div>
                </div>
                <!-- Last name END -->
            </div>

            <div class="col-sm-6">
    <div class="d-flex align-items-center rounded border px-3 py-2">
        <div class="w-100">
            <p class="mb-1">
                <i class="bi bi-briefcase fa-fw me-2"></i>
                Role:
                <strong id="aboutRoleText">{{ $user->role ?: 'Not specified' }}</strong>
            </p>
            <input type="text" class="form-control d-none"
                id="aboutRoleInput" name="role"
                value="{{ $user->role }}" placeholder="Your role">
        </div>
    </div>
</div>
<div class="col-sm-6">
    <div class="d-flex align-items-center rounded border px-3 py-2">
        <div class="w-100">
            <p class="mb-1">
                <i class="bi bi-heart fa-fw me-2"></i>
                Status:
                <strong id="aboutStatusText">
                    {{ $user->status ? ucfirst($user->status) : 'Not specified' }}
                </strong>
            </p>

            <select class="form-control d-none"
                id="aboutStatusInput" name="status">
                <option value="">Select status</option>
                <option value="single" {{ $user->status=='single'?'selected':'' }}>Single</option>
                <option value="married" {{ $user->status=='married'?'selected':'' }}>Married</option>
            </select>
        </div>
    </div>
</div>

            <div class="col-sm-12">
    <div class="d-flex align-items-center rounded border px-3 py-2">
        <div class="w-100">
            <p class="mb-1">
                <i class="bi bi-geo-alt fa-fw me-2"></i>
                Address:
                <strong id="aboutAddressText">{{ $user->address ?: 'Not specified' }}</strong>
            </p>

            <textarea class="form-control d-none"
                id="aboutAddressInput"
                name="address"
                rows="2"
                placeholder="Your address">{{ $user->address }}</textarea>
        </div>
    </div>
</div>


            <div class="col-sm-6">
                <!-- Joined on START -->
                <div class="d-flex align-items-center rounded border px-3 py-2">
                    <p class="mb-0">
                        <i class="bi bi-clock-history fa-fw me-2"></i>
                        Joined on:
                        <strong>{{ $user->created_at ? $user->created_at->format('M d, Y') : 'Not available' }}</strong>
                    </p>
                </div>
                <!-- Joined on END -->
            </div>

            <div class="col-sm-6">
                <!-- Email START -->
                <div class="d-flex align-items-center rounded border px-3 py-2">
                    <div class="w-100">
                    <p class="mb-1">
                        <i class="bi bi-envelope fa-fw me-2"></i>
                        Email:
                        <strong id="aboutEmailText">{{ $user->email }}</strong>
                    </p>
                    <input type="email" class="form-control d-none" id="aboutEmailInput" name="email"
                        value="{{ $user->email }}">
                    </div>
                </div>
                <!-- Email END -->
            </div>
            <div class="col-sm-6 position-relative">
                <a class="btn btn-dashed rounded w-100" href="#!">
                    <i class="bi bi-plus-circle-dotted me-1"></i>Add an Information
                </a>
            </div>
        </div>
            <div class="text-end mt-3 d-none" id="aboutActions">
                <button type="button" class="btn btn-sm btn-secondary me-2" id="aboutCancelBtn">Cancel</button>
                <button type="submit" class="btn btn-sm btn-primary" id="aboutSaveBtn">Update</button>
            </div>
        </form>
    </div>
    <!-- Card body END -->
</div>


          <div class="card">
            <!-- Card header START -->
            <div class="card-header d-sm-flex justify-content-between border-0 pb-0">
              <h5 class="card-title">Interests</h5>
              <a class="btn btn-primary-soft btn-sm" href="#!"> See all</a>
            </div>
            <!-- Card header END -->
            <!-- Card body START -->
            <div class="card-body">
              <div class="row g-4">
                <div class="col-sm-6 col-lg-4">
                  <!-- Interests item START -->
                  <div class="d-flex align-items-center position-relative">
                      <div class="avatar">
                        <img class="avatar-img" src="assets/images/logo/04.svg" alt="">
                      </div>
                      <div class="ms-2">
                        <h6 class="mb-0"> <a class="stretched-link" href="#"> Oracle </a></h6>
                        <p class="small mb-0">7,546,224 followers</p>
                      </div>
                  </div>
                  <!-- Interests item END -->
                </div>
                <div class="col-sm-6 col-lg-4">
                  <!-- Interests item START -->
                  <div class="d-flex align-items-center position-relative">
                      <div class="avatar">
                        <img class="avatar-img" src="assets/images/logo/13.svg" alt="">
                      </div>
                      <div class="ms-2">
                        <h6 class="mb-0"> <a class="stretched-link" href="#"> Apple </a></h6>
                        <p class="small mb-0">102B followers</p>
                      </div>
                  </div>
                  <!-- Interests item END -->
                </div>
                <div class="col-sm-6 col-lg-4">
                  <!-- Interests item START -->
                  <div class="d-flex align-items-center position-relative">
                      <div class="avatar">
                        <img class="avatar-img rounded-circle" src="assets/images/avatar/placeholder.jpg" alt="">
                      </div>
                      <div class="ms-2">
                        <h6 class="mb-0"> <a class="stretched-link" href="#"> Elon musk </a></h6>
                        <p class="small mb-0"> CEO and Product Architect of Tesla, Inc 41B followers</p>
                      </div>
                  </div>
                  <!-- Interests item END -->
                </div>
                <div class="col-sm-6 col-lg-4">
                  <!-- Interests item START -->
                  <div class="d-flex align-items-center position-relative">
                      <div class="avatar">
                        <img class="avatar-img" src="assets/images/events/04.jpg" alt="">
                      </div>
                      <div class="ms-2">
                        <h6 class="mb-0"> <a class="stretched-link" href="#"> The X Factor </a></h6>
                        <p class="small mb-0">9,654 followers</p>
                      </div>
                  </div>
                  <!-- Interests item END -->
                </div>
                <div class="col-sm-6 col-lg-4">
                  <!-- Interests item START -->
                  <div class="d-flex align-items-center position-relative">
                      <div class="avatar">
                        <img class="avatar-img rounded-circle" src="assets/images/logo/12.svg" alt="">
                      </div>
                      <div class="ms-2">
                        <h6 class="mb-0"> <a class="stretched-link" href="#"> Getbootstrap </a></h6>
                        <p class="small mb-0">8,457,224 followers</p>
                      </div>
                  </div>
                  <!-- Interests item END -->
                </div>
              </div>
            </div>
            <!-- Card body END -->
          </div>