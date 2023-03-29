{# Index Page #}
{& templates/common/header.tpl &}

{% foreach items as card %}

    {& templates/components/card.tpl &}

{% endforeach %}

{& templates/common/footer.tpl &}