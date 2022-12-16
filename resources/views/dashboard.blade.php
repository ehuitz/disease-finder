<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    {{-- add save search form here --}}
                    <div class="m-8">

                        <label for="disease-search" class="block text-sm font-medium text-gray-700">Disease Search -
                            atleast 3 characters</label>
                        <!-- input element used for typing the search  -->
                        <input id="disease-search" type="text"
                            class="ctw-input block w-full rounded-md border-gray-300 pl-7 pr-12 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm""
                            autocomplete="off" data-ctw-ino="1">
                        <!-- div element used for showing the search results -->
                        <div class="ctw-window relative" data-ctw-ino="1"></div>
                    </div>



                </div>
            </div>


        </div>
    </div>
    </div>


    @push('scripts')
        <script>
            const mySettings = {
                // The API located at the URL below should be used only     // for software development and testing.
                // ICD content at this location might not
                // be up to date or complete.
                // For production, use the API located at
                // id.who.int with proper OAUTH authentication
                apiServerUrl: "https://id.who.int",
                apiSecured: true
            };

            // example of an Embedded Coding Tool using the callback selectedEntityFunction
            // for copying the code selected in an <input> element and clear the search results
            const myCallbacks = {
                selectedEntityFunction: (selectedEntity) => {
                    // paste the code into the <input>
                    document.getElementById('disease-search').value = selectedEntity.code + " - " +
                        selectedEntity.bestMatchText;



                },

                getNewTokenFunction: async () => {
                    // if the embedded browser is working with the cloud hosted ICD-API, you need to set apiSecured=true
                    // In this case embedded browser calls this function when it needs a new token.
                    // In this case you backend web application should provide updated tokens

                    const url =
                        "{{ route('icd.token') }}" // we assume this backend script returns a JSON {'token': '...'}
                    try {
                        const response = await fetch(url);
                        const result = await response.json();
                        const token = result.token;
                        return token; // the function return is required
                    } catch (e) {
                        console.log("Error during the request");
                    }
                }
            };

            // configure the ECT Handler with mySettings and myCallbacks
            ECT.Handler.configure(mySettings, myCallbacks);
        </script>
    @endpush

</x-app-layout>
