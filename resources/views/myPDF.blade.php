<!DOCTYPE html>
<html>
<head>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
	<h1>{{ $title }}</h1>
    <table class="min-w-max w-full table-auto">
        <thead>
            <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                <th class="py-3 px-6 text-left">Marca</th>
                <th class="py-3 px-6 text-left">Modelo</th>
                <th class="py-3 px-6 text-left">Cantidad</th>
            </tr>
        </thead>
        <tbody class="text-gray-600 text-sm font-light">
            @foreach ($reporte as $vehicle)
                <tr class="border-b border-gray-200 hover:bg-gray-100">
                    <td class="py-3 px-6 text-left whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="mr-2">
                                <span class="font-medium">{{ $vehicle->Marca }}</span>
                            </div>
                    </td>
                    <td class="py-3 px-6 text-left">
                        <div class="flex items-center">
                            <span>{{ $vehicle->Modelo }}</span>
                        </div>
                    </td>
                    <td class="py-3 px-6 text-left">
                        <div class="flex items-center">
                            <span>{{ $vehicle->Cantidad }}</span>
                        </div>
                    </td>
                    
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>