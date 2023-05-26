<p><b>Hello {{ ucfirst($name) }},</b><br><br>We have received your reset password request if you have requested for same, Please</p>
<p><a href="{{ route('admin.generate.password',['email'=>Crypt::encrypt($email),'code'=>Crypt::encrypt($code)]) }}">click here</a> for new password.</p>

<br>
Thanks,<br>
GGPA Website Team
