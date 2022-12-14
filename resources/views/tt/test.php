<!-- {{ csrf() }} -->

{% foreach($names as $name): %}
{{ $name }}
{% endforeach; %}
