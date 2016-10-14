<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="LearnAlone - Uma plataforma de ensino a distância" />
    <title>Learn Alone</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="../css/styles.css" />
</head>
<body>

<div class="content container">
    <nav class="navbar navbar-inverse">
	  <div class="container-fluid">
	    <div class="navbar-header">
	      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>                        
	      </button>
	      <a class="navbar-brand" href="#">Learn Alone</a>
	    </div>
	    <div class="collapse navbar-collapse" id="myNavbar">
	      <ul class="nav navbar-nav">
	        <li class="active"><a href="{% url 'core:home' %}">Início</a></li>
	        <li><a href="{%  url 'cursos:cursos' %}">Cursos</a></li>
	        <li><a href="{%  url 'core:contato' %}">Contato</a></li>
	      </ul>
	      <ul class="nav navbar-nav navbar-right">
	      	{% if user.is_authenticated %}
	      	<li><a href="{% url 'accounts:painel' %}"> Painel</a></li>
	        <li><a href="{% url 'accounts:logout' %}"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
	        {% else %}
	        <li><a href="{% url 'accounts:login' %}"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
	        {% endif %}
	      </ul>
	    </div>
	  </div>
	</nav>
    
	{% block content %}
	{% endblock %}

    <div class="footer">
        Learn Alone - Uma plataforma de ensino a distância
    </div>
</div>	
</body>
</html>