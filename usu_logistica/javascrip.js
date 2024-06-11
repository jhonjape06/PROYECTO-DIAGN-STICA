$(document).ready(function() {
    // Fetch providers when the page loads
    fetchProviders();

  
    // Function to fetch providers
    function fetchProviders() {
        $.ajax({
            url: 'listar_proveedores.php',
            type: 'GET',
            success: function(response) {
                var data = JSON.parse(response);
                if (data.success) {
                    // Populate the select field with providers
                    var options = '<option value="">Selecciona un proveedor</option>';
                    data.proveedores.forEach(function(proveedor) {
                        options += '<option value="' + proveedor.id + '">' + proveedor.empresa + '</option>';
                    });
                    $('#proveedor').html(options);
                } else {
                    alert(data.error);
                    $('#proveedor').html('<option value="">Error al cargar proveedores</option>');
                }
            },
            error: function(xhr, status, error) {
                console.error(error);
                alert('Error al cargar proveedores.');
                $('#proveedor').html('<option value="">Error al cargar proveedores</option>');
            }
        });
    }

   
        $.ajax({
            type: "GET",
            url: "../cargar_proveedores.php", // Ruta al archivo PHP que carga los proveedores
            success: function(data) {
                $("#proveedor").html(data);
            }
        });
    
    
});
