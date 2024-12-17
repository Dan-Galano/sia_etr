<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>PSUnify - Sign Up</title>
    <link rel="icon" type="image/png" href="{{ asset('images/PSUnifylogo.png') }}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/scrollbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/signup.css') }}">
    <style>
        body {
            background-image: url('{{ asset('images/bgcover.png') }}');
            background-attachment: fixed;
            background-size: cover;
            background-repeat: no-repeat;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .file-preview {
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 8px 15px;
            margin-bottom: 8px;
            background-color: #f9f9f9;
            display: flex;
            align-items: center;
            justify-content: space-between;
            max-width: 250px;
        }

        .file-name {
            flex: 1;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            margin-right: 10px;
            max-width: 150px;
        }

        .file-preview button {
            background: none;
            border: none;
            color: #d9534f;
            font-weight: bold;
            cursor: pointer;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

    <div class="signup-container">
        <!-- Dropdown to select user type -->
        <div class="form-group">
            <label for="type">Register as:</label>
            <select class="form-control" id="type" name="type" onchange="updateFormFields()">
                <option value="member" selected>Student</option>
                <option value="organizer">Organization</option>
            </select>
        </div>

        <!-- Form for student registration -->
        <form id="student-form" method="POST" action="{{ route('signupStudent') }}" enctype="multipart/form-data"
            style="display: block;">
            @csrf
            <input type="hidden" id="userTypeMember" value="member">

            <div class="form-group text-center">
                <a href="{{ route('landing') }}"><img src="{{ asset('images/psunifylogotext.png') }}" alt="Logo"
                        height="80"></a>
                <h3>Sign Up as a Student</h3>
            </div>
            <div class="form-group">
                <label for="stud_email">Email address</label>
                <input type="email" class="form-control" id="stud_email" name="stud_email"
                    value="{{ old('stud_email') }}">
                @error('stud_email')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="stud_password">Password</label>
                <input type="password" class="form-control" id="stud_password" name="password">

                @error('stud_password')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="row">
                <div class="form-group col-4">
                    <label for="firstname">First Name</label>
                    <input type="text" class="form-control" id="firstname" name="firstname"
                        value="{{ old('firstname') }}">
                    @error('firstname')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-4">
                    <label for="middlename">Middle Name</label>
                    <input type="text" class="form-control" id="middlename" name="middlename"
                        value="{{ old('middlename') }}">
                    @error('middlename')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-4">
                    <label for="lastname">Last Name</label>
                    <input type="text" class="form-control" id="lastname" name="lastname"
                        value="{{ old('lastname') }}">
                    @error('lastname')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <label for="studentid">Student ID</label>
                <input type="text" class="form-control" id="studentid" name="studentid"
                    value="{{ old('studentid') }}">
                @error('studentid')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="photo">Profile Photo</label>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="photo" name="photo" accept="image/*"
                        onchange="previewPhoto(event)">
                    <label class="custom-file-label" for="photo">Choose Photo</label>
                </div>
                <div class="text-center">
                    <img id="photo-preview" class="img ml-2 rounded-circle mx-auto" src="#"
                        style="display: none; width: 200px; height: 200px; margin: 20px;">
                </div>
                @error('photo')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group text-center">
                <button type="button" id="signup-member-button" class="btn btn-primary btn-block">Sign Up as
                    Student</button>
            </div>
            <div class="form-group text-center">
                <p>Already have an account? <a href="{{ route('signin') }}">Sign In</a></p>
            </div>
        </form>

        <!-- Form for organization registration -->
        <form id="organization-form" method="POST" action="{{ route('signupOrganization') }}"
            enctype="multipart/form-data" style="display: none;">
            @csrf
            <input type="hidden" id="userTypeOrganizer" value="organizer">

            <div class="form-group text-center">
                <a href="{{ route('landing') }}"><img src="{{ asset('images/psunifylogotext.png') }}"
                        alt="Logo" height="80"></a>
                <h3>Sign Up as an Organization</h3>
            </div>
            <div class="form-group">
                <label for="orgname">Organization's Name</label>
                <input type="text" class="form-control" id="orgname" name="orgname"
                    value="{{ old('orgname') }}">
                @error('orgname')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="org_email">Organization's Email address</label>
                <input type="email" class="form-control" id="org_email" name="org_email"
                    value="{{ old('org_email') }}">
                @error('org_email')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="org_password">Password</label>
                <input type="password" class="form-control" id="org_password" name="org_password">
                @error('org_password')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="program">Program:</label>
                <select class="form-control" id="program" name="program">
                    <option value="Bachelor of Arts in English Language">Bachelor of Arts in English Language</option>
                    <option value="Bachelor of Early Childhood Education">Bachelor of Early Childhood Education
                    </option>
                    <option value="Bachelor of Science in Information Technology">Bachelor of Science in Information
                        Technology</option>
                    <option value="Bachelor of Science in Mathematics">Bachelor of Science in Mathematics</option>
                    <option value="Bachelor of Science in Architecture">Bachelor of Science in Architecture</option>
                    <option value="Bachelor of Science in Civil Engineering">Bachelor of Science in Civil Engineering
                    </option>
                    <option value="Bachelor of Science in Computer Engineering">Bachelor of Science in Computer
                        Engineering</option>
                    <option value="Bachelor of Science in Electrical Engineering">Bachelor of Science in Electrical
                        Engineering</option>
                    <option value="Bachelor of Science in Mechanical Engineering">Bachelor of Science in Mechanical
                        Engineering</option>
                    <option value="No Specific Program (Open to All)">No Specific Program (Open to All)</option>
                </select>
                @error('program')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="bio">Bio:</label>
                <textarea class="form-control" id="bio" name="bio">{{ old('bio') }}</textarea>
                @error('bio')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="mission">Mission</label>
                <textarea class="form-control" id="mission" name="mission" rows="3">{{ old('mission') }}</textarea>
                @error('mission')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="vision">Vision</label>
                <textarea class="form-control" id="vision" name="vision" rows="3">{{ old('vision') }}</textarea>
                @error('vision')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="org_logo">Organization Logo</label>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="org_logo" name="org_logo" accept="image/*"
                        onchange="previewOrgLogo(event)">
                    <label class="custom-file-label" for="org_logo">Choose Logo</label>
                </div>
                @error('org_logo')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <img id="org-logo-preview" class="img ml-2 rounded-circle mx-auto"
                    style="display:none; max-width: 200px; margin-top: 10px;" alt="Logo Preview">
            </div>
            <div class="form-group">
                <label>Upload Required Documents (CBL, Principles, Rules, etc.)</label>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="documents" name="documents[]"
                        accept=".pdf,.docx,.jpg,.png,.jpeg" multiple onchange="handleFileSelect(event)">
                    <label class="custom-file-label" for="documents">Choose Documents</label>
                </div>
                <div id="file-preview-container" class="mt-3"></div>
                @error('documents')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group row">
                <div class="col-md-6">
                    <label for="contact">Contact</label>
                    <input type="text" class="form-control" id="contact" name="contact"
                        value="{{ old('contact') }}">
                </div>
                <div class="col-md-6">
                    <label for="facebook">Facebook <span class="text-muted">(Optional)</span></label>
                    <input type="text" class="form-control" id="facebook" name="facebook"
                        value="{{ old('facebook') }}">
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-6">
                    <label for="instagram">Instagram <span class="text-muted">(Optional)</span></label>
                    <input type="text" class="form-control" id="instagram" name="instagram"
                        value="{{ old('instagram') }}">
                </div>
                <div class="col-md-6">
                    <label for="twitter">Twitter/X <span class="text-muted">(Optional)</span></label>
                    <input type="text" class="form-control" id="twitter" name="twitter"
                        value="{{ old('twitter') }}">
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-6">
                    <label for="tiktok">TikTok <span class="text-muted">(Optional)</span></label>
                    <input type="text" class="form-control" id="tiktok" name="tiktok"
                        value="{{ old('tiktok') }}">
                </div>
                <div class="col-md-6">
                    <label for="youtube">YouTube <span class="text-muted">(Optional)</span></label>
                    <input type="text" class="form-control" id="youtube" name="youtube"
                        value="{{ old('youtube') }}">
                </div>
            </div>

            <div class="form-group text-center">
                <button type="button" id="signup-organizer-button" class="btn btn-primary btn-block">Sign Up as
                    Organization</button>
            </div>
            <div class="form-group text-center">
                <p>Already have an account? <a href="{{ route('signin') }}">Sign In</a></p>
            </div>
        </form>
    </div>




    <script>
        function updateFormFields() {
            var userType = document.getElementById('type').value;

            if (userType === 'member') {
                document.getElementById('student-form').style.display = 'block';
                document.getElementById('organization-form').style.display = 'none';
            } else if (userType === 'organizer') {
                document.getElementById('student-form').style.display = 'none';
                document.getElementById('organization-form').style.display = 'block';
            }
        }


        function logMemberFormValues() {
            var userType = document.getElementById('userTypeMember').value;
            var firstName = document.getElementById('firstname').value;
            var middleName = document.getElementById('middlename').value;
            var lastName = document.getElementById('lastname').value;
            var studentId = document.getElementById('studentid').value;
            var email = document.getElementById('stud_email').value;
            var photo = document.getElementById('photo').files[0] ? document.getElementById('photo').files[0].name :
                'No photo selected';
            var password = document.getElementById('stud_password').value;

            // Prepare FormData for AJAX request
            var formData = new FormData();
            formData.append('userType', userType);
            formData.append('firstname', firstName);
            formData.append('middlename', middleName);
            formData.append('lastname', lastName);
            formData.append('studentid', studentId);
            formData.append('stud_email', email);
            formData.append('photo', document.getElementById('photo').files[0]);
            formData.append('password', password);

            // Get CSRF token from the meta tag
            var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // Send data to the backend using AJAX
            fetch("{{ route('signupStudent') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken // Include CSRF token in the request headers
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Display success message with SweetAlert2
                        Swal.fire({
                            title: 'Success!',
                            text: 'Student account created successfully!',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            // Redirect to the signin page after success
                            window.location.href = '/signin'; // Redirect to '/signin' page
                        });
                    } else {
                        // Display error message with SweetAlert2
                        Swal.fire({
                            title: 'Error!',
                            text: 'Error: ' + data.message,
                            icon: 'error',
                            confirmButtonText: 'Try Again'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        title: 'Error!',
                        text: 'An error occurred while processing your request. Please try again.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                });
        }

        function logOrganizerFormValues() {
            // Collect form data
            var formData = new FormData();
            formData.append('orgname', document.getElementById('orgname').value);
            formData.append('org_email', document.getElementById('org_email').value);
            formData.append('org_password', document.getElementById('org_password').value);
            formData.append('program', document.getElementById('program').value);
            formData.append('bio', document.getElementById('bio').value);
            formData.append('mission', document.getElementById('mission').value);
            formData.append('vision', document.getElementById('vision').value);
            formData.append('contact', document.getElementById('contact').value || null);
            formData.append('facebook', document.getElementById('facebook').value || null);
            formData.append('instagram', document.getElementById('instagram').value || null);
            formData.append('twitter', document.getElementById('twitter').value || null);
            formData.append('tiktok', document.getElementById('tiktok').value || null);
            formData.append('youtube', document.getElementById('youtube').value || null);

            var documents = document.getElementById('documents').files;
            for (var i = 0; i < documents.length; i++) {
                formData.append('documents[]', documents[i]);
            }

            var logoFile = document.getElementById('org_logo').files[0];
            if (logoFile) {
                formData.append('org_logo', logoFile);
            }

            var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch("{{ route('signupOrganization') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Display success message with SweetAlert2
                        Swal.fire({
                            title: 'Success!',
                            text: data.message,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            // Redirect to the signin page after success
                            window.location.href = '/signin'; // Redirect to '/signin' page
                        });
                    } else {
                        // Display error message with SweetAlert2
                        Swal.fire({
                            title: 'Error!',
                            text: 'Error: ' + data.message,
                            icon: 'error',
                            confirmButtonText: 'Try Again'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        title: 'Error!',
                        text: 'An error occurred while processing your request: ' + error.message,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                });

        }







        window.onload = function() {
            updateFormFields();

            // Event listener for the Student Signup button
            document.getElementById('signup-member-button').addEventListener('click', function(event) {
                event.preventDefault(); // Prevent the default form submission
                logMemberFormValues(); // Collect the values and submit via AJAX
            });

            // Event listener for the Organization Signup button
            document.getElementById('signup-organizer-button').addEventListener('click', function(event) {
                event.preventDefault(); // Prevent the default form submission
                logOrganizerFormValues(); // Collect the values and submit via AJAX
            });
        };
    </script>





    <script>
        function previewPhoto(event) {
            var preview = document.getElementById('photo-preview');
            var file = event.target.files[0];
            var reader = new FileReader();
            reader.onload = function() {
                preview.src = reader.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        }

        function previewOrgLogo(event) {
            var preview = document.getElementById('org-logo-preview');
            var file = event.target.files[0];
            var reader = new FileReader();
            reader.onload = function() {
                preview.src = reader.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        }

        function handleFileSelect(event) {
            const files = event.target.files;
            const previewContainer = document.getElementById('file-preview-container');
            previewContainer.innerHTML = '';

            for (let i = 0; i < files.length; i++) {
                const file = files[i];

                const fileDiv = document.createElement('div');
                fileDiv.classList.add('file-preview', 'd-inline-block', 'mr-2', 'mt-2');
                fileDiv.style.border = '1px solid #ccc';
                fileDiv.style.borderRadius = '8px';
                fileDiv.style.padding = '8px 15px';
                fileDiv.style.marginBottom = '8px';
                fileDiv.style.backgroundColor = '#f9f9f9';
                fileDiv.style.display = 'flex';
                fileDiv.style.alignItems = 'center';
                fileDiv.style.justifyContent = 'space-between';
                fileDiv.style.maxWidth = '250px';

                const fileName = document.createElement('span');
                const truncatedName = file.name.length > 10 ? file.name.substring(0, 10) + '...' : file.name;
                fileName.textContent = truncatedName;
                fileName.classList.add('file-name');
                fileName.style.flex = '1';
                fileName.style.overflow = 'hidden';
                fileName.style.textOverflow = 'ellipsis';
                fileName.style.whiteSpace = 'nowrap';
                fileName.style.marginRight = '10px';

                const removeButton = document.createElement('button');
                removeButton.textContent = 'x';
                removeButton.style.background = 'none';
                removeButton.style.border = 'none';
                removeButton.style.color = '#d9534f';
                removeButton.style.fontWeight = 'bold';
                removeButton.style.cursor = 'pointer';

                removeButton.addEventListener('click', function() {
                    removeFile(file);
                    fileDiv.remove();
                });

                fileDiv.appendChild(fileName);
                fileDiv.appendChild(removeButton);

                previewContainer.appendChild(fileDiv);
            }
        }

        function removeFile(file) {
            const fileInput = document.getElementById('documents');
            const dataTransfer = new DataTransfer();
            for (let i = 0; i < fileInput.files.length; i++) {
                if (fileInput.files[i] !== file) {
                    dataTransfer.items.add(fileInput.files[i]);
                }
            }
            fileInput.files = dataTransfer.files;
        }
    </script>




</body>

</html>
