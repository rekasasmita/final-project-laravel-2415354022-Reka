<x-layout>
    <x-slot:title>Customers - ERP</x-slot>

    <div class="flex items-center justify-between border-b border-gray-200 pb-4 mb-8 -mx-8 px-8 -mt-8 pt-5 bg-white shadow-xs">
        <h1 class="text-base font-semibold text-gray-700">Customers</h1>
    </div>

    <div class="w-full">
        <div class="flex justify-end mb-5">
            <button onclick="openModal('add')" class="bg-slate-800 hover:bg-slate-700 text-white px-4 py-2 rounded-lg text-sm font-medium flex items-center gap-2 shadow-sm transition-colors cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Add Data
            </button>
        </div>

        <div class="bg-white rounded-xl border border-gray-200/60 shadow-xs overflow-visible">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-gray-100 text-xs font-semibold text-gray-500 uppercase bg-gray-50/70 tracking-wider">
                        <th class="py-4 px-6">Customer ID</th>
                        <th class="py-4 px-6">Customer Name</th>
                        <th class="py-4 px-6">Email</th>
                        <th class="py-4 px-6">Address</th>
                        <th class="py-4 px-6">Status</th>
                        <th class="py-4 px-6 text-center w-24">Action</th>
                    </tr>
                </thead>
                <tbody id="customer-table-body" class="text-sm text-gray-700 divide-y divide-gray-100">
                    </tbody>
            </table>
        </div>
    </div>

    <div id="modalAddCustomer" class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/50 backdrop-blur-sm transition-opacity px-4">
        <div class="bg-white w-full max-w-lg rounded-2xl shadow-2xl overflow-hidden transform transition-all scale-95 duration-300" id="modalAddContent">
            <div class="p-6 border-b border-gray-100 text-center">
                <h3 class="text-xl font-bold text-gray-800">Add Customer</h3>
            </div>
            <form id="formAddCustomer" class="p-8 space-y-5">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Customer ID</label>
                    <input type="text" name="customer_id" placeholder="Enter ID" required class="w-full px-4 py-3 border border-gray-200 rounded-xl outline-none focus:ring-2 focus:ring-slate-800 focus:border-slate-800 transition-all">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Customer Name</label>
                    <input type="text" name="name" placeholder="Enter name" required class="w-full px-4 py-3 border border-gray-200 rounded-xl outline-none focus:ring-2 focus:ring-slate-800 focus:border-slate-800 transition-all">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Email</label>
                    <input type="email" name="email" placeholder="Enter email" class="w-full px-4 py-3 border border-gray-200 rounded-xl outline-none focus:ring-2 focus:ring-slate-800 focus:border-slate-800 transition-all">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Address</label>
                    <input type="text" name="address" placeholder="Enter address" class="w-full px-4 py-3 border border-gray-200 rounded-xl outline-none focus:ring-2 focus:ring-slate-800 focus:border-slate-800 transition-all">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Status</label>
                    <select name="status" required class="w-full px-4 py-3 border border-gray-200 rounded-xl outline-none focus:ring-2 focus:ring-slate-800 focus:border-slate-800 transition-all bg-white cursor-pointer">
                        <option value="" disabled selected>Select Status</option>
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>
                <div class="flex items-center justify-end gap-3 pt-4">
                    <button type="button" onclick="closeModal('add')" class="px-6 py-2.5 text-sm font-medium text-gray-500 hover:bg-gray-100 rounded-lg cursor-pointer">Cancel</button>
                    <button type="submit" id="btnSubmitAdd" class="px-8 py-2.5 bg-slate-800 hover:bg-slate-900 text-white text-sm font-bold rounded-lg shadow-lg cursor-pointer">Submit</button>
                </div>
            </form>
        </div>
    </div>

    <div id="modalEditCustomer" class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/50 backdrop-blur-sm transition-opacity px-4">
        <div class="bg-white w-full max-w-lg rounded-2xl shadow-2xl overflow-hidden transform transition-all scale-95 duration-300" id="modalEditContent">
            <div class="p-6 border-b border-gray-100 text-center">
                <h3 class="text-xl font-bold text-gray-800">Edit Customer</h3>
            </div>
            <form id="formEditCustomer" class="p-8 space-y-5">
                <input type="hidden" id="edit_db_id">
                
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Customer ID</label>
                    <input type="text" id="edit_customer_id" name="customer_id" required class="w-full px-4 py-3 border border-gray-200 rounded-xl outline-none focus:ring-2 focus:ring-slate-800 focus:border-slate-800 transition-all">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Customer Name</label>
                    <input type="text" id="edit_name" name="name" required class="w-full px-4 py-3 border border-gray-200 rounded-xl outline-none focus:ring-2 focus:ring-slate-800 focus:border-slate-800 transition-all">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Email</label>
                    <input type="email" id="edit_email" name="email" class="w-full px-4 py-3 border border-gray-200 rounded-xl outline-none focus:ring-2 focus:ring-slate-800 focus:border-slate-800 transition-all">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Address</label>
                    <input type="text" id="edit_address" name="address" class="w-full px-4 py-3 border border-gray-200 rounded-xl outline-none focus:ring-2 focus:ring-slate-800 focus:border-slate-800 transition-all">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Status</label>
                    <select id="edit_status" name="status" required class="w-full px-4 py-3 border border-gray-200 rounded-xl outline-none focus:ring-2 focus:ring-slate-800 focus:border-slate-800 transition-all bg-white cursor-pointer">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>
                <div class="flex items-center justify-end gap-3 pt-4">
                    <button type="button" onclick="closeModal('edit')" class="px-6 py-2.5 text-sm font-medium text-gray-500 hover:bg-gray-100 rounded-lg cursor-pointer">Cancel</button>
                    <button type="submit" id="btnSubmitEdit" class="px-8 py-2.5 bg-slate-800 hover:bg-slate-900 text-white text-sm font-bold rounded-lg shadow-lg cursor-pointer">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let currentCustomers = [];

        function openModal(type) {
            const modal = document.getElementById(type === 'add' ? 'modalAddCustomer' : 'modalEditCustomer');
            const content = document.getElementById(type === 'add' ? 'modalAddContent' : 'modalEditContent');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            setTimeout(() => { content.classList.replace('scale-95', 'scale-100'); }, 10);
        }

        function closeModal(type) {
            const modal = document.getElementById(type === 'add' ? 'modalAddCustomer' : 'modalEditCustomer');
            const content = document.getElementById(type === 'add' ? 'modalAddContent' : 'modalEditContent');
            content.classList.replace('scale-100', 'scale-95');
            setTimeout(() => {
                modal.classList.replace('flex', 'hidden');
                if(type === 'add') document.getElementById('formAddCustomer').reset();
            }, 200);
        }

        async function fetchCustomers() {
            try {
                const response = await fetch('/api/customers');
                const result = await response.json();
                const tableBody = document.getElementById('customer-table-body');
                tableBody.innerHTML = ''; 

                if (result.success && result.data.length > 0) {
                    currentCustomers = result.data;

                    currentCustomers.forEach(customer => {
                        const statusBadge = customer.status 
                            ? '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700 border border-green-200/50">Active</span>'
                            : '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-700 border border-red-200/50">Inactive</span>';

                        
                        tableBody.innerHTML += `
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="py-4 px-6 font-medium text-gray-600">${customer.customer_id}</td>
                                <td class="py-4 px-6 font-medium text-gray-900">${customer.name}</td>
                                <td class="py-4 px-6 text-gray-500">${customer.email || '-'}</td>
                                <td class="py-4 px-6 text-gray-500">${customer.address || '-'}</td>
                                <td class="py-4 px-6">${statusBadge}</td>
                                <td class="py-4 px-6 text-center relative overflow-visible">
                                    
                                    <button onclick="toggleActionMenu(event, '${customer.id}')" class="text-gray-400 hover:text-gray-700 p-1.5 rounded-lg hover:bg-gray-100 transition-all inline-flex items-center cursor-pointer">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 9h16.5m-16.5 6.75h16.5" />
                                        </svg>
                                    </button>

                                    <div id="dropdown-${customer.id}" class="hidden absolute right-12 mt-1 w-36 bg-white border border-gray-200/80 rounded-xl shadow-lg z-50 py-1.5 text-left transition-all">
                                        <button onclick="updateStatus('${customer.id}', true)" class="w-full px-4 py-2 text-xs text-gray-700 hover:bg-gray-50 flex items-center gap-2.5 font-medium cursor-pointer">
                                            <svg class="w-3.5 h-3.5 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            Active
                                        </button>
                                        <button onclick="updateStatus('${customer.id}', false)" class="w-full px-4 py-2 text-xs text-gray-700 hover:bg-gray-50 flex items-center gap-2.5 font-medium cursor-pointer">
                                            <svg class="w-3.5 h-3.5 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                                            Inactive
                                        </button>
                                        <button onclick="triggerEditModal('${customer.id}')" class="w-full px-4 py-2 text-xs text-gray-700 hover:bg-gray-50 flex items-center gap-2.5 font-medium cursor-pointer">
                                            <svg class="w-3.5 h-3.5 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                            Edit
                                        </button>
                                        <div class="border-t border-gray-100 my-1"></div>
                                        <button onclick="deleteCustomer('${customer.id}')" class="w-full px-4 py-2 text-xs text-red-600 hover:bg-red-50 flex items-center gap-2.5 font-semibold cursor-pointer">
                                            <svg class="w-3.5 h-3.5 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            Delete
                                        </button>
                                    </div>

                                </td>
                            </tr>`;
                    });
                } else {
                    tableBody.innerHTML = '<tr><td colspan="6" class="py-10 text-center text-gray-400">Belum ada data customer.</td></tr>';
                }
            } catch (error) { console.error(error); }
        }

        function toggleActionMenu(event, id) {
            event.stopPropagation();
            document.querySelectorAll('[id^="dropdown-"]').forEach(menu => {
                if (menu.id !== `dropdown-${id}`) menu.classList.add('hidden');
            });
            document.getElementById(`dropdown-${id}`).classList.toggle('hidden');
        }
        document.addEventListener('click', () => {
            document.querySelectorAll('[id^="dropdown-"]').forEach(menu => menu.classList.add('hidden'));
        });

        // 1. UBAH STATUS (PUT)
        async function updateStatus(dbId, targetStatus) {
            const customer = currentCustomers.find(c => c.id == dbId);
            if (!customer) return;

            const bodyPayload = {
                customer_id: customer.customer_id,
                name: customer.name,
                email: customer.email,
                address: customer.address,
                status: targetStatus
            };

            try {
                const response = await fetch(`/api/customers/${dbId}`, {
                    method: 'PUT',
                    headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
                    body: JSON.stringify(bodyPayload)
                });
                if (response.ok) { fetchCustomers(); } 
                else { alert('Gagal merubah status.'); }
            } catch (error) { console.error(error); }
        }

        // 2. MUNCULKAN FORM EDIT
        function triggerEditModal(dbId) {
            const customer = currentCustomers.find(c => c.id == dbId);
            if (!customer) return;

            document.getElementById('edit_db_id').value = customer.id;
            document.getElementById('edit_customer_id').value = customer.customer_id;
            document.getElementById('edit_name').value = customer.name;
            document.getElementById('edit_email').value = customer.email || '';
            document.getElementById('edit_address').value = customer.address || '';
            document.getElementById('edit_status').value = customer.status ? "1" : "0";

            openModal('edit');
        }

        // SAVE EDIT (PUT)
        document.getElementById('formEditCustomer').addEventListener('submit', async function(e) {
            e.preventDefault();
            const dbId = document.getElementById('edit_db_id').value;
            const btn = document.getElementById('btnSubmitEdit');

            const formData = new FormData(this);
            const data = Object.fromEntries(formData.entries());
            data.status = data.status === "1";

            btn.disabled = true;
            btn.innerHTML = 'Saving...';

            try {
                const response = await fetch(`/api/customers/${dbId}`, {
                    method: 'PUT',
                    headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
                    body: JSON.stringify(data)
                });
                const result = await response.json();

                if (response.ok && result.success) {
                    closeModal('edit');
                    fetchCustomers();
                } else { alert('Gagal Update: ' + (result.message || 'Error')); }
            } catch (error) { alert('Error Jaringan.'); }
            finally {
                btn.disabled = false;
                btn.innerHTML = 'Save Changes';
            }
        });

        // 3. DELETE CUSTOMER (DELETE)
        async function deleteCustomer(dbId) {
            if (!confirm('Apakah Anda yakin ingin menghapus Customer ini?')) return;

            try {
                const response = await fetch(`/api/customers/${dbId}`, {
                    method: 'DELETE',
                    headers: { 'Accept': 'application/json' }
                });
                if (response.ok) { fetchCustomers(); } 
                else { alert('Gagal menghapus data.'); }
            } catch (error) { console.error(error); }
        }

        // SAVE NEW DATA (POST)
        document.getElementById('formAddCustomer').addEventListener('submit', async function(e) {
            e.preventDefault();
            const btn = document.getElementById('btnSubmitAdd');
            const formData = new FormData(this);
            const data = Object.fromEntries(formData.entries());
            data.status = data.status === "1";

            btn.disabled = true;
            btn.innerHTML = 'Submitting...';

            try {
                const response = await fetch('/api/customers', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
                    body: JSON.stringify(data)
                });
                if (response.ok) {
                    closeModal('add');
                    fetchCustomers();
                } else { alert('Gagal menambah customer.'); }
            } catch (error) { alert('Error Jaringan.'); }
            finally {
                btn.disabled = false;
                btn.innerHTML = 'Submit';
            }
        });

        document.addEventListener('DOMContentLoaded', fetchCustomers);
    </script>
</x-layout>