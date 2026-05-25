<x-layout>
    <x-slot:title>Services Management - ERP</x-slot>

    <div class="flex items-center justify-between border-b border-gray-200 pb-4 mb-8 -mx-8 px-8 -mt-8 pt-5 bg-white shadow-xs">
        <h1 class="text-base font-semibold text-gray-700">Services</h1>
    </div>

    <div class="w-full">
        <div class="flex justify-end mb-5">
            <button onclick="openModal('add')" class="bg-slate-800 hover:bg-slate-700 text-white px-4 py-2 rounded-lg text-sm font-medium flex items-center gap-2 shadow-sm transition-colors cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Add Service
            </button>
        </div>

        <div class="bg-white rounded-xl border border-gray-200/60 shadow-xs overflow-visible">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-gray-100 text-xs font-semibold text-gray-500 uppercase bg-gray-50/70 tracking-wider">
                        <th class="py-4 px-6">Service ID</th>
                        <th class="py-4 px-6 text-left">Service Name</th>
                        <th class="py-4 px-6">Description</th>
                        <th class="py-4 px-6">Price</th>
                        <th class="py-4 px-6">Status</th>
                        <th class="py-4 px-6 text-center w-24">Action</th>
                    </tr>
                </thead>
                <tbody id="service-table-body" class="text-sm text-gray-700 divide-y divide-gray-100">
                </tbody>
            </table>
        </div>
    </div>

    <div id="modalAddService" class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/50 backdrop-blur-sm px-4">
        <div class="bg-white w-full max-w-lg rounded-2xl shadow-2xl overflow-hidden transform transition-all scale-95 duration-300" id="modalAddContent">
            <div class="p-6 border-b border-gray-100 text-center"><h3 class="text-xl font-bold text-gray-800">Add New Service</h3></div>
            <form id="formAddService" class="p-8 space-y-5">
                <div><label class="block text-sm font-bold text-gray-700 mb-2">Service Name</label><input type="text" name="name" required class="w-full px-4 py-3 border border-gray-200 rounded-xl outline-none focus:ring-2 focus:ring-slate-800 transition-all"></div>
                <div><label class="block text-sm font-bold text-gray-700 mb-2">Description</label><textarea name="description" rows="3" class="w-full px-4 py-3 border border-gray-200 rounded-xl outline-none focus:ring-2 focus:ring-slate-800 transition-all"></textarea></div>
                <div><label class="block text-sm font-bold text-gray-700 mb-2">Price (IDR)</label><input type="number" name="price" required class="w-full px-4 py-3 border border-gray-200 rounded-xl outline-none focus:ring-2 focus:ring-slate-800 transition-all"></div>
                <div><label class="block text-sm font-bold text-gray-700 mb-2">Status</label><select name="status" required class="w-full px-4 py-3 border border-gray-200 rounded-xl outline-none bg-white cursor-pointer"><option value="1">Active</option><option value="0">Inactive</option></select></div>
                <div class="flex items-center justify-end gap-3 pt-4"><button type="button" onclick="closeModal('add')" class="px-6 py-2.5 text-sm font-medium text-gray-500 hover:bg-gray-100 rounded-lg">Cancel</button><button type="submit" id="btnSubmitAdd" class="px-8 py-2.5 bg-slate-800 text-white text-sm font-bold rounded-lg shadow-lg">Submit</button></div>
            </form>
        </div>
    </div>

    <div id="modalEditService" class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/50 backdrop-blur-sm px-4">
        <div class="bg-white w-full max-w-lg rounded-2xl shadow-2xl overflow-hidden transform transition-all scale-95 duration-300" id="modalEditContent">
            <div class="p-6 border-b border-gray-100 text-center"><h3 class="text-xl font-bold text-gray-800">Edit Service</h3></div>
            <form id="formEditService" class="p-8 space-y-5">
                <input type="hidden" id="edit_db_id">
                <div><label class="block text-sm font-bold text-gray-700 mb-2">Service Name</label><input type="text" id="edit_name" name="name" required class="w-full px-4 py-3 border border-gray-200 rounded-xl outline-none focus:ring-2 focus:ring-slate-800 transition-all"></div>
                <div><label class="block text-sm font-bold text-gray-700 mb-2">Description</label><textarea id="edit_description" name="description" rows="3" class="w-full px-4 py-3 border border-gray-200 rounded-xl outline-none focus:ring-2 focus:ring-slate-800 transition-all"></textarea></div>
                <div><label class="block text-sm font-bold text-gray-700 mb-2">Price (IDR)</label><input type="number" id="edit_price" name="price" required class="w-full px-4 py-3 border border-gray-200 rounded-xl outline-none focus:ring-2 focus:ring-slate-800 transition-all"></div>
                <div><label class="block text-sm font-bold text-gray-700 mb-2">Status</label><select id="edit_status" name="status" required class="w-full px-4 py-3 border border-gray-200 rounded-xl outline-none bg-white cursor-pointer"><option value="1">Active</option><option value="0">Inactive</option></select></div>
                <div class="flex items-center justify-end gap-3 pt-4"><button type="button" onclick="closeModal('edit')" class="px-6 py-2.5 text-sm font-medium text-gray-500 hover:bg-gray-100 rounded-lg">Cancel</button><button type="submit" id="btnSubmitEdit" class="px-8 py-2.5 bg-slate-800 text-white text-sm font-bold rounded-lg shadow-lg">Save Changes</button></div>
            </form>
        </div>
    </div>

    <script>
        let currentServices = [];
        function openModal(type) {
            const modal = document.getElementById(type === 'add' ? 'modalAddService' : 'modalEditService');
            const content = document.getElementById(type === 'add' ? 'modalAddContent' : 'modalEditContent');
            modal.classList.replace('hidden', 'flex');
            setTimeout(() => { content.classList.replace('scale-95', 'scale-100'); }, 10);
        }
        function closeModal(type) {
            const modal = document.getElementById(type === 'add' ? 'modalAddService' : 'modalEditService');
            const content = document.getElementById(type === 'add' ? 'modalAddContent' : 'modalEditContent');
            content.classList.replace('scale-100', 'scale-95');
            setTimeout(() => { modal.classList.replace('flex', 'hidden'); }, 200);
        }

        async function fetchServices() {
            try {
                const response = await fetch('/api/services');
                const result = await response.json();
                const tableBody = document.getElementById('service-table-body');
                tableBody.innerHTML = ''; 
                if (result.success && result.data.length > 0) {
                    currentServices = result.data;
                    currentServices.forEach(service => {
                        const statusBadge = service.status 
                            ? '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700 border border-green-200/50">Active</span>'
                            : '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-700 border border-red-200/50">Inactive</span>';
                        tableBody.innerHTML += `
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="py-4 px-6 font-medium text-gray-600">SRV-${service.id.toString().padStart(4, '0')}</td>
                                <td class="py-4 px-6 font-medium text-gray-900">${service.name}</td>
                                <td class="py-4 px-6 text-gray-500 truncate max-w-xs">${service.description || '-'}</td>
                                <td class="py-4 px-6 text-gray-900 font-semibold">Rp ${new Intl.NumberFormat('id-ID').format(service.price)}</td>
                                <td class="py-4 px-6">${statusBadge}</td>
                                <td class="py-4 px-6 text-center relative">
                                    <button onclick="toggleActionMenu(event, '${service.id}')" class="text-gray-400 hover:text-gray-700 p-1.5 rounded-lg hover:bg-gray-100 cursor-pointer">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 9h16.5m-16.5 6.75h16.5" /></svg>
                                    </button>
                                    <div id="dropdown-${service.id}" class="hidden absolute right-12 mt-1 w-36 bg-white border border-gray-200 rounded-xl shadow-lg z-50 py-1.5 text-left">
                                        <button onclick="updateStatus('${service.id}', true)" class="w-full px-4 py-2 text-xs text-gray-700 hover:bg-gray-50 flex items-center gap-2 font-medium"><svg class="w-3.5 h-3.5 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg> Active</button>
                                        <button onclick="updateStatus('${service.id}', false)" class="w-full px-4 py-2 text-xs text-gray-700 hover:bg-gray-50 flex items-center gap-2 font-medium"><svg class="w-3.5 h-3.5 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg> Inactive</button>
                                        <button onclick="triggerEditModal('${service.id}')" class="w-full px-4 py-2 text-xs text-gray-700 hover:bg-gray-50 flex items-center gap-2 font-medium"><svg class="w-3.5 h-3.5 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg> Edit</button>
                                        <div class="border-t border-gray-100 my-1"></div>
                                        <button onclick="deleteService('${service.id}')" class="w-full px-4 py-2 text-xs text-red-600 hover:bg-red-50 flex items-center gap-2 font-semibold"><svg class="w-3.5 h-3.5 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg> Delete</button>
                                    </div>
                                </td>
                            </tr>`;
                    });
                }
            } catch (error) { console.error(error); }
        }

        // --- Driver Logic (Action Menu, CRUD) ---
        function toggleActionMenu(e, id) { e.stopPropagation(); document.querySelectorAll('[id^="dropdown-"]').forEach(m => { if (m.id !== `dropdown-${id}`) m.classList.add('hidden'); }); document.getElementById(`dropdown-${id}`).classList.toggle('hidden'); }
        document.addEventListener('click', () => { document.querySelectorAll('[id^="dropdown-"]').forEach(m => m.classList.add('hidden')); });

        async function updateStatus(id, s) { 
            const service = currentServices.find(c => c.id == id);
            try { await fetch(`/api/services/${id}`, { method: 'PUT', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify({...service, status: s}) }); fetchServices(); } catch (e) {} 
        }

        function triggerEditModal(id) {
            const s = currentServices.find(c => c.id == id);
            document.getElementById('edit_db_id').value = s.id;
            document.getElementById('edit_name').value = s.name;
            document.getElementById('edit_description').value = s.description || '';
            document.getElementById('edit_price').value = s.price;
            document.getElementById('edit_status').value = s.status ? "1" : "0";
            openModal('edit');
        }

        document.getElementById('formAddService').addEventListener('submit', async function(e) {
            e.preventDefault();
            const data = Object.fromEntries(new FormData(this).entries());
            data.status = data.status === "1";
            try { await fetch('/api/services', { method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify(data) }); closeModal('add'); fetchServices(); } catch (e) {}
        });

        document.getElementById('formEditService').addEventListener('submit', async function(e) {
            e.preventDefault();
            const id = document.getElementById('edit_db_id').value;
            const data = Object.fromEntries(new FormData(this).entries());
            data.status = data.status === "1";
            try { await fetch(`/api/services/${id}`, { method: 'PUT', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify(data) }); closeModal('edit'); fetchServices(); } catch (e) {}
        });

        async function deleteService(id) { if (confirm('Hapus layanan ini?')) { try { await fetch(`/api/services/${id}`, { method: 'DELETE' }); fetchServices(); } catch (e) {} } }

        document.addEventListener('DOMContentLoaded', fetchServices);
    </script>
</x-layout>