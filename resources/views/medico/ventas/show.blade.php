<x-app-layout>
    <div class="bg-gray-100 min-h-screen flex justify-center items-center">
        <div class="bg-white shadow-lg rounded-lg p-8 mx-4 my-8" style="width: 1700px; height: 800px;">
            <!-- Información del Paciente -->
            <div class="flex justify-between items-center mb-6 border-b-2 pb-4">
                <div class="flex items-center">
                    <div class="flex items-center justify-center h-12 w-12 rounded-full bg-white text-xl font-bold border-2" style="border-color: #2D7498; color: #33AD9B;">
                        {{ substr($paciente->nombres, 0, 1) }}{{ substr($paciente->apepat, 0, 1) }}
                    </div>
                    <h2 class="text-3xl font-bold text-left ml-4" style="color: black;">
                        {{ $paciente->nombres }} {{ $paciente->apepat }} {{ $paciente->apemat }}
                    </h2>
                </div>
                <p class="text-lg font-medium">
                    Edad: 
                    <?php
                        $fecha_nacimiento = \Carbon\Carbon::parse($paciente->fechanac);
                        $edad = $fecha_nacimiento->diff(\Carbon\Carbon::now());
                        echo $edad->y . ' años ' . $edad->m . ' meses ' . $edad->d . ' días';
                    ?>
                </p>
            </div>

            <!-- Contenido Principal: Productos y Carrito -->
            <div class="flex" style="height: calc(100% - 128px);">
                <!-- Contenedor de Selección de Productos -->
                <div class="w-1/2 pr-4">
                    <h2 class="text-2xl font-bold mb-4">Seleccionar Productos:</h2>
                    <input type="text" id="buscar-producto" class="mb-4 p-2 border rounded w-full" placeholder="Buscar producto...">
                    <div id="productos-lista" style="max-height: 500px; overflow-y: auto;">
                        @foreach ($productos as $producto)
                            <div class="mb-4 p-4 rounded border flex items-center producto-item">
                                <div class="flex-grow">
                                    <h3 class="font-bold">{{ $producto->nombre }}</h3>
                                    <p class="text-sm text-gray-600">{{ $producto->descripcion }}</p>
                                    <p class="text-sm text-gray-500">Cantidad disponible: {{ $producto->inventario }}</p>
                                    <p class="text-lg font-semibold mt-1">${{ number_format($producto->precio, 2) }}</p>
                                </div>
                                <div>
                                    <button class="bg-[#2D7498] text-white px-4 py-2 rounded" onclick="agregarAlCarrito({{ $producto->id }}, '{{ $producto->nombre }}', {{ $producto->precio }}, {{ $producto->inventario }})">Agregar</button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Contenedor del Carrito -->
                <div class="w-1/2 pl-4">
                    <h2 class="text-2xl font-bold mb-4">Carrito de Compras</h2>
                    <form id="carrito-form" action="{{ route('ventas.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="consulta_id" value="{{ $venta->consulta_id }}">
                        <input type="hidden" name="precio_consulta" value="{{ $venta->precio_consulta }}">
                        <input type="hidden" name="iva" value="{{ $venta->iva }}">
                        <input type="hidden" name="total" id="input-total" value="{{ $venta->total }}">
                        <input type="hidden" name="paciente_id" value="{{ $venta->paciente_id }}">

                        <div id="carrito-items" style="max-height: 400px; overflow-y: auto;">
                            <!-- Aquí se mostrarán los productos agregados al carrito -->
                        </div>

                        <div class="mt-4">
                            <p><strong>Precio de la Consulta:</strong> $<span id="precio_consulta">{{ number_format($venta->precio_consulta, 2) }}</span></p>
                            <p><strong>IVA:</strong> $<span id="iva">{{ number_format($venta->iva, 2) }}</span></p>
                            <p><strong>Total a Pagar:</strong> $<span id="total">{{ number_format($venta->total, 2) }}</span></p>
                            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-md mt-4">Guardar Venta</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript para gestionar el carrito y los productos -->
    <script>
        let carrito = [];
    
        function agregarAlCarrito(id, nombre, precio, inventario) {
            let item = carrito.find(producto => producto.id === id);
            if (item) {
                if(item.cantidad < inventario) {
                    item.cantidad += 1;
                } else {
                    alert("No hay suficiente inventario para agregar más de este producto.");
                }
            } else {
                carrito.push({ id, nombre, precio, cantidad: 1, inventario });
            }
            actualizarCarrito();
        }
    
        function actualizarCarrito() {
            let carritoItems = document.getElementById('carrito-items');
            carritoItems.innerHTML = '';
    
            let total = parseFloat(document.getElementById('precio_consulta').innerText);
    
            carrito.forEach(producto => {
                let subtotal = producto.precio * producto.cantidad;
                carritoItems.innerHTML += `
                    <div class="mb-4 p-4 rounded border flex items-center justify-between">
                        <div class="flex-grow">
                            <h3 class="font-bold">${producto.nombre}</h3>
                            <p class="text-sm text-gray-600">Precio unitario: $${producto.precio.toFixed(2)}</p>
                            <input type="hidden" name="productos[${producto.id}][id]" value="${producto.id}">
                            <input type="hidden" name="productos[${producto.id}][cantidad]" value="${producto.cantidad}">
                            <input type="number" name="productos[${producto.id}][cantidad]" value="${producto.cantidad}" min="1" max="${producto.inventario}" class="w-16 mt-2 p-1 border rounded" oninput="cambiarCantidad(${producto.id}, this.value)">
                            <p class="text-sm mt-2">Subtotal: $<span>${subtotal.toFixed(2)}</span></p>
                        </div>
                        <button type="button" class="bg-red-500 text-white px-4 py-2 rounded" onclick="eliminarDelCarrito(${producto.id})">Eliminar</button>
                    </div>
                `;
    
                total += subtotal;
            });
    
            let iva = total * 0.16;
            total += iva;
    
            document.getElementById('iva').innerText = iva.toFixed(2);
            document.getElementById('total').innerText = total.toFixed(2);
            document.getElementById('input-total').value = total.toFixed(2);
        }
    
        function cambiarCantidad(id, cantidad) {
            let item = carrito.find(producto => producto.id === id);
            if (item) {
                if(cantidad <= item.inventario) {
                    item.cantidad = parseInt(cantidad);
                } else {
                    alert("No puedes exceder la cantidad disponible en inventario.");
                    item.cantidad = item.inventario;
                }
            }
            actualizarCarrito();
        }
    
        function eliminarDelCarrito(id) {
            carrito = carrito.filter(producto => producto.id !== id);
            actualizarCarrito();
        }
    
        document.getElementById('buscar-producto').addEventListener('input', function() {
            let filter = this.value.toLowerCase();
            document.querySelectorAll('.producto-item').forEach(function(item) {
                let nombre = item.querySelector('h3').textContent.toLowerCase();
                if (nombre.includes(filter)) {
                    item.style.display = '';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    </script>    
</x-app-layout>
