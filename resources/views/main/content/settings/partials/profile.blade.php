<div class="tab-pane show active fade" id="nav-setting-tab-1">
                    <!-- Account settings START -->
                    <div class="card mb-4">

                        <!-- Title START -->
                        <div class="card-header border-0 pb-0">
                            <h1 class="h5 card-title">Account Settings</h1>
                            <p class="mb-0">He moonlights difficult engrossed it, sportsmen. Interested has all
                                Devonshire difficulty gay assistance joy. Unaffected at ye of compliment alteration to.</p>
                        </div>
                        <!-- Card header START -->
                        <!-- Card body START -->
                        <div class="card-body">
                            <!-- Form settings START -->
                            <form class="row g-3" method="POST" action="{{ route('profile.update') }}"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PATCH')
                                <!-- First name -->
                                <div class="col-sm-6 col-lg-4">
                                    <label class="form-label">First name</label>
                                    <input type="text" name="first_name" class="form-control"
                                        placeholder="first name"
                                        value="{{ old('first_name', Auth::user()->first_name) }}">
                                </div>

                                <!-- Last name -->
                                <div class="col-sm-6 col-lg-4">
                                    <label class="form-label">Last name</label>
                                    <input type="text" name="last_name" class="form-control" placeholder="last name"
                                        value="{{ old('last_name', Auth::user()->last_name) }}">
                                </div>

                                <div class="col-sm-6 col-lg-4">
                                    <label class="form-label">Image</label>
                                    <input type="file" name="image" class="form-control" placeholder="image"
                                        value="{{ old('image', Auth::user()->image) }}" accept="image/*">
                                </div>

                                <!-- Username -->
                                <div class="col-sm-6">
                                    <label class="form-label">User name</label>
                                    <input type="text" name="username" class="form-control"
                                        value="{{ old('username', Auth::user()->username) }}">
                                </div>

                                <!-- Birthday -->
                                <div class="col-lg-6">
                                    <label class="form-label">Birthday</label>
                                    <input type="text" name="date_of_birth" class="form-control flatpickr"
                                        value="{{ old('date_of_birth', Auth::user()->date_of_birth) }}">
                                </div>

                                <!-- Phone -->
                                <div class="col-sm-6">
                                    <label class="form-label">Phone number</label>
                                    <input type="text" name="phone_number" class="form-control"
                                        value="{{ old('phone_number', Auth::user()->phone_number) }}">
                                </div>

                                <!-- Email -->
                                <div class="col-sm-6">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control"
                                        value="{{ old('email', Auth::user()->email) }}">
                                </div>

                                <!-- Overview -->
                                <div class="col-12">
                                    <label class="form-label">Overview</label>
                                    <textarea name="description" class="form-control" rows="4">{{ old('description', Auth::user()->description) }}</textarea>
                                    <small>Maximun 300 words limit</small>
                                </div>

                                <!-- Button -->
                                <div class="col-12 text-end">
                                    <button type="submit" class="btn btn-sm btn-primary">Save changes</button>
                                </div>
                            </form>

                            <!-- Settings END -->
                        </div>
                        <!-- Card body END -->
                    </div>
                    <!-- Account settings END -->

                    <!-- Change your password START -->
                    {{-- <div class="card">
                        <!-- Title START -->
                        <div class="card-header border-0 pb-0">
                            <h5 class="card-title">Change your password</h5>
                            <p class="mb-0">See resolved goodness felicity shy civility domestic had but.</p>
                        </div>
                        <!-- Title START -->
                        <div class="card-body">
                            <!-- Settings START -->
                            <form class="row g-3">
                                <!-- Current password -->
                                <div class="col-12">
                                    <label class="form-label">Current password</label>
                                    <input type="text" class="form-control" placeholder="">
                                </div>
                                <!-- New password -->
                                <div class="col-12">
                                    <label class="form-label">New password</label>
                                    <!-- Input group -->
                                    <div class="input-group">
                                        <input class="form-control fakepassword" type="password" id="psw-input"
                                            placeholder="Enter new password">
                                        <span class="input-group-text p-0">
                                            <i
                                                class="fakepasswordicon fa-solid fa-eye-slash cursor-pointer p-2 w-40px"></i>
                                        </span>
                                    </div>
                                    <!-- Pswmeter -->
                                    <div id="pswmeter" class="mt-2"></div>
                                    <div id="pswmeter-message" class="rounded mt-1"></div>
                                </div>
                                <!-- Confirm password -->
                                <div class="col-12">
                                    <label class="form-label">Confirm password</label>
                                    <input type="text" class="form-control" placeholder="">
                                </div>
                                <!-- Button  -->
                                <div class="col-12 text-end">
                                    <button type="submit" class="btn btn-primary mb-0">Update password</button>
                                </div>
                            </form>
                            <!-- Settings END -->
                        </div>
                    </div> --}}
                    <!-- Card END -->
                </div>