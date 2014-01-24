<body>
{ "result": "true", "message":"cool"  }
<%
response.write(request.form("fname"))
response.write(" " & request.form("lname"))
%>
</body>
