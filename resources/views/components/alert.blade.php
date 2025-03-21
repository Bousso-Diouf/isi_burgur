@if(session('success'))
    <div id="success-alert" class="bg-green-100 border-t-4 border-green-500 rounded-b text-green-900 px-4 py-3 shadow-md my-4" role="alert">
        <div class="flex">
            <div>
                <p class="font-bold">Succès</p>
                <p class="text-sm">{{ session('success') }}</p>
            </div>
        </div>
    </div>
@endif

@if(session('error'))
    <div id="error-alert" class="bg-red-100 border-t-4 border-red-500 rounded-b text-red-900 px-4 py-3 shadow-md my-4" role="alert">
        <div class="flex">
            <div>
                <p class="font-bold">Erreur</p>
                <p class="text-sm">{{ session('error') }}</p>
            </div>
        </div>
    </div>
@endif

@if(session('info'))
    <div id="info-alert" class="bg-blue-100 border-t-4 border-blue-500 rounded-b text-blue-900 px-4 py-3 shadow-md my-4" role="alert">
        <div class="flex">
            <div>
                <p class="font-bold">Information</p>
                <p class="text-sm">{{ session('info') }} </p>
            </div>
        </div>
    </div>
@endif


<script>
    document.addEventListener('DOMContentLoaded', function () {
        const successAlert = document.getElementById('success-alert');
        const errorAlert = document.getElementById('error-alert');
        const infoAlert = document.getElementById('info-alert');
        
        if (successAlert) {
            setTimeout(() => {
                successAlert.style.display = 'none';
            }, 5000); // 5000ms = 5 seconds
        }
        
        if (errorAlert) {
            setTimeout(() => {
                errorAlert.style.display = 'none';
            }, 5000); // 5000ms = 5 seconds
        }

        if (infoAlert) {
            setTimeout(() => {
                infoAlert.style.display = 'none';
            }, 5000); // 5000ms = 5 seconds
        }
    });

</script>