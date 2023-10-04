<script type="text/javascript">
  $(document).ready(function()
  {
      $("#form1").on("submit",function(e)
      {
        e.preventDefault();
        var username = $("#korisnickoime").val();
        var email = $("#email").val();
        if (username !=="" && email !== "") 
        {
                $.ajax({
                url : "provjeriKorisnickoIme.php",
                type : "POST",
                cache:false,
                data : {username:username,email:email},
                success:function(result){
                    if (result == 1) {
                    $("#message").text('Korisničko ime i lozinka već postoje u bazi.');
                    }else{
                    $("#message").text('Uspješna registracija.');
                    }
                }
                });
         }
         else
         {
            $("#message").text('Molimo vas popunite sva polja. ');
         }
      })
  });
</script>

