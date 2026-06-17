<h2>New job match found!</h2>

<p><strong>Position:</strong> {{ $job->title }}</p>
<p><strong>Company:</strong> {{ $job->company }}</p>
<p><strong>Location:</strong> {{ $job->location }}</p>
<p><a href="{{ $job->url }}">View Job</a></p>