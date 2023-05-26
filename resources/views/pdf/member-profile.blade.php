<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Member Profile</title>
  <style>
  #members {
    font-family: Arial, Helvetica, sans-serif;
    /* border-collapse: collapse !important; */
    border: 2px solid !important;
    width: 100%;
  }

  #user {
    font-family: Arial, Helvetica, sans-serif;
    /* border-collapse: collapse; */
    border: 2px solid !important;
    width: 100%;
  }

  #members td, #members th {
    border: 1px solid #f2f2f2;
    padding: 8px;
  }

  #user td, #user th {
    border: 1px solid #f2f2f2;
    padding: 8px;
  }

  </style>
</head>
<body>
  <div class="container">
    <center>
      <h1>{{ $user->first_name." ".$user->last_name }}</h1>

      <table id="user" border="2" align="center" cellspacing="5" cellpadding="5" >
        <tr>
          <th>First Name</th>
          <td>{{ $user->first_name }}</td>
        </tr>
        <tr>
          <th>Last Name</th>
          <td>{{ $user->last_name }}</td>
        </tr>
        <tr>
          <th>Gender</th>
          <td>{{ $user->gender }}</td>
        </tr>
        <tr>
          <th>DOB</th>
          <td>{{ $user->dob }}</td>
        </tr>
        <tr>
          <th>Mobile Number</th>
          <td>{{ $user->mobile_number }}</td>
        </tr>
        <tr>
          <th>State</th>
          <td>{{ $user->state }}</td>
        </tr>
        <tr>
          <th>City</th>
          <td>{{ $user->city }}</td>
        </tr>
        <tr>
          <th>Address</th>
          <td>{{ $user->address }}</td>
        </tr>
        <tr>
          <th>Education Type</th>
          <td>{{ $user->education_type }}</td>
        </tr>
        <tr>
          <th>Job Type</th>
          <td>{{ $user->job_type }}</td>
        </tr>
        {{--
          <tr>
            <th>Profile Pic</th>
            <td>@if(!empty($user->profile_pic)) <img src="{{ public_path('uploads/images/'.$user->getRawOriginal('profile_pic')) }}" width="50" > @endif</td>
          </tr>
          <tr>
            <th>Additional Attachment</th>
            <td>@if(!empty($user->additional_attachment)) <img src="{{ public_path('uploads/images/'.$user->getRawOriginal('additional_attachment')) }}" width="50" > @endif</td>
          </tr>

          <tr>
            <th>Profile Pic</th>
            <td>@if(!empty($user->profile_pic)) <img src="{{ $user->profile_pic }}" width="50" > @endif</td>
          </tr>
          <tr>
            <th>Additional Attachment</th>
            <td>@if(!empty($user->additional_attachment)) <img src="{{ $user->additional_attachment }}" width="50" > @endif</td>
          </tr> --}}
       
      </table>
      <h1>Members</h1>
      <table id="members" border="2" align="center" cellspacing="5" cellpadding="5" >
        <thead>
          <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Relation</th>
          </tr>
        </thead>
        <tbody>
          @foreach($memberData as $value)
            <tr>
              <td>{{ $value->first_name }}</td>
              <td>{{ $value->last_name }}</td>
              <td>{{ $value->relation }}</td>
            <tr>
          @endforeach
        </tbody>
      </table>
    </center>
  </div>
</body>
</html>