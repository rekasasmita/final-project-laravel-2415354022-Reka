<x-layout>
    <x-slot:title>Subscriptions Management - ERP</x-slot>

    <div class="flex items-center justify-between border-b border-gray-200 pb-4 mb-8 -mx-8 px-8 -mt-8 pt-5 bg-white shadow-xs">
        <h1 class="text-base font-semibold text-gray-700">Subscriptions</h1>
    </div>

    <div class="w-full">
        <div class="flex justify-end mb-5">
            <button onclick="openModal('add')" class="bg-slate-800 hover:bg-slate-700 text-white px-4 py-2 rounded-lg text-sm font-medium flex items-center gap-2 shadow-sm transition-colors cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Add Subscription
            </button>
        </div>

        <div class="bg-white rounded-xl border border-gray-200/60 shadow-xs overflow-visible">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-gray-100 text-xs font-semibold text-gray-500 uppercase bg-gray-50/70 tracking-wider">
                        <th class="py-4 px-6">Customer</th>
                        <th class="py-4 px-6">Service</th>
                        <th class="py-4 px-6">Start Date</th>
                        <th class="py-4 px-6">End Date</th>
                        <th class="py-4 px-6">Status</th>
                        <th class="py-4 px-6 text-center w-24">Action</th>
                    </tr>
                </thead>
                <tbody id="subscription-table-body" class="text-sm text-gray-700 divide-y divide-gray-100"></tbody>
            </table>
        </div>
    </div>

    <!-- ADD MODAL -->
    <div id="modalAddSubscription" class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/50 backdrop-blur-sm px-4">
        <div class="bg-white w-full max-w-xl rounded-2xl shadow-2xl overflow-hidden transform transition-all scale-95 duration-300" id="modalAddContent">
            <div class="p-6 border-b border-gray-100 text-center">
                <h3 class="text-xl font-bold text-gray-800">Add Subscription</h3>
            </div>

            <form id="formAddSubscription" class="p-8 space-y-5">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Customer</label>
                    <select name="customer_id" id="customerSelect" required class="w-full px-4 py-3 border border-gray-200 rounded-xl outline-none bg-white">
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Service</label>
                    <select name="service_id" id="serviceSelect" required class="w-full px-4 py-3 border border-gray-200 rounded-xl outline-none bg-white">
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Start Date</label>
                        <input type="date" name="start_date" class="w-full px-4 py-3 border border-gray-200 rounded-xl outline-none">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">End Date</label>
                        <input type="date" name="end_date" class="w-full px-4 py-3 border border-gray-200 rounded-xl outline-none">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Status</label>
                    <select name="status" required class="w-full px-4 py-3 border border-gray-200 rounded-xl outline-none bg-white">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                        <option value="trial">Trial</option>
                        <option value="isolir">Isolir</option>
                        <option value="dismantle">Dismantle</option>
                    </select>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4">
                    <button type="button" onclick="closeModal('add')" class="px-6 py-2.5 text-sm font-medium text-gray-500 hover:bg-gray-100 rounded-lg">
                        Cancel
                    </button>

                    <button type="submit" class="px-8 py-2.5 bg-slate-800 text-white text-sm font-bold rounded-lg shadow-lg">
                        Submit
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let currentSubscriptions = [];
        let customers = [];
        let services = [];

        function openModal(type) {
            const modal = document.getElementById(type === 'add' ? 'modalAddSubscription' : 'modalEditSubscription');
            const content = document.getElementById(type === 'add' ? 'modalAddContent' : 'modalEditContent');

            modal.classList.remove('hidden');
            modal.classList.add('flex');

            setTimeout(() => {
                content.classList.replace('scale-95', 'scale-100');
            }, 10);
        }

        function closeModal(type) {
            const modal = document.getElementById(type === 'add' ? 'modalAddSubscription' : 'modalEditSubscription');
            const content = document.getElementById(type === 'add' ? 'modalAddContent' : 'modalEditContent');

            content.classList.replace('scale-100', 'scale-95');

            setTimeout(() => {
                modal.classList.replace('flex', 'hidden');
            }, 200);
        }

        async function fetchSubscriptions() {
            try {
                const response = await fetch('/api/subscriptions');
                const result = await response.json();

                const tableBody = document.getElementById('subscription-table-body');
                tableBody.innerHTML = '';

                if (result.success && result.data.length > 0) {
                    currentSubscriptions = result.data;

                    currentSubscriptions.forEach(subscription => {
                        let statusBadge = '';

                        switch(subscription.status) {
                            case 'active':
                                statusBadge = '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700">Active</span>';
                                break;
                            case 'inactive':
                                statusBadge = '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-700">Inactive</span>';
                                break;
                            case 'trial':
                                statusBadge = '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-700">Trial</span>';
                                break;
                            case 'isolir':
                                statusBadge = '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-700">Isolir</span>';
                                break;
                            case 'dismantle':
                                statusBadge = '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-700">Dismantle</span>';
                                break;
                        }

                        tableBody.innerHTML += `
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="py-4 px-6 font-medium text-gray-900">${subscription.customer?.name ?? '-'}</td>
                                <td class="py-4 px-6 text-gray-600">${subscription.service?.name ?? '-'}</td>
                                <td class="py-4 px-6 text-gray-500">${subscription.start_date ?? '-'}</td>
                                <td class="py-4 px-6 text-gray-500">${subscription.end_date ?? '-'}</td>
                                <td class="py-4 px-6">${statusBadge}</td>
                                <td class="py-4 px-6 text-center">
                                    <button onclick="deleteSubscription('${subscription.id}')" class="text-red-500 hover:text-red-700 text-sm font-medium cursor-pointer">
                                        Delete
                                    </button>
                                </td>
                            </tr>
                        `;
                    });
                } else {
                    tableBody.innerHTML = `
                        <tr>
                            <td colspan="6" class="py-10 text-center text-gray-400">
                                No subscriptions found.
                            </td>
                        </tr>
                    `;
                }
            } catch (error) {
                console.error(error);
            }
        }

        async function fetchCustomers() {
            const response = await fetch('/api/customers');
            const result = await response.json();

            if (result.success) {
                customers = result.data;

                const select = document.getElementById('customerSelect');
                select.innerHTML = '<option value="">Select Customer</option>';

                customers.forEach(customer => {
                    select.innerHTML += `
                        <option value="${customer.id}">${customer.name}</option>
                    `;
                });
            }
        }

        async function fetchServices() {
            const response = await fetch('/api/services');
            const result = await response.json();

            if (result.success) {
                services = result.data;

                const select = document.getElementById('serviceSelect');
                select.innerHTML = '<option value="">Select Service</option>';

                services.forEach(service => {
                    select.innerHTML += `
                        <option value="${service.id}">${service.name}</option>
                    `;
                });
            }
        }

        document.getElementById('formAddSubscription').addEventListener('submit', async function(e) {
            e.preventDefault();

            const formData = new FormData(this);

            const payload = {
                customer_id: formData.get('customer_id'),
                service_id: formData.get('service_id'),
                start_date: formData.get('start_date'),
                end_date: formData.get('end_date'),
                status: formData.get('status'),
            };

            try {
                const response = await fetch('/api/subscriptions', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(payload)
                });

                if (response.ok) {
                    closeModal('add');
                    this.reset();
                    fetchSubscriptions();
                } else {
                    alert('Failed to create subscription');
                }
            } catch (error) {
                console.error(error);
            }
        });

        async function deleteSubscription(id) {
            const confirmed = confirm('Delete this subscription?');
            if (!confirmed) return;

            try {
                const response = await fetch(`/api/subscriptions/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'Accept': 'application/json'
                    }
                });

                if (response.ok) {
                    fetchSubscriptions();
                } else {
                    alert('Failed to delete subscription');
                }
            } catch (error) {
                console.error(error);
            }
        }

        fetchSubscriptions();
        fetchCustomers();
        fetchServices();
    </script>
</x-layout>
