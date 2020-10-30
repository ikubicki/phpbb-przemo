example-sub.tpl:

{% for b1 in block1 %}

<p>I'm inside of block1</p>
{% for b2 in block1.block2 %}
<p>I'm inside of block1 and block2</p>
{% if b2.cond1 %}
<p>cond1: I'm inside of block1 and block2</p>
{% endif %}
{% endfor %}
{{ VARIABLE }}
{% endfor %}


<!-- BEGIN block1.block2 -->
<!-- IF block1.block2.cond2 -->
<p>cond2: I'm inside of block</p>
<!-- ENDIF block1.block2.cond2 -->
<!-- END block1.block2 -->