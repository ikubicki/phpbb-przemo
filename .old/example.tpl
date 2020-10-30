example.tpl:

<br />
<h1>Hello world!</h1>
<?php echo "I'm a PHP script!" ?>
<p>{{ VARIABLE }}</p>
{% if cond1 %}
<p>I'm inside of cond1</p>
{% endif %}

{{ include('example-sub.tpl') }}