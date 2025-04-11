<div x-data="userMultiSelect({{ json_encode($selections) }})" class="relative w-full">
    <!-- Selected Items -->
    <div class="flex flex-wrap items-center justify-between p-1 bg-white border border-gray-300 rounded-md cursor-pointer min-h-[40px]"
         @click="open = !open">
        <div class="flex flex-wrap items-center">
            <template x-if="selectedUsers.length === 0">
                <span class="text-gray-700">Select a Month</span>
            </template>
            <template x-for="user in selectedUsers" :key="user.id">
                <div class="flex items-center bg-blue-100 text-blue-800 text-sm font-medium mr-2 mb-1 px-2.5 py-0.5 rounded">
                    <span x-text="user.name"></span>
                    <button @click.stop="removeUser(user)" class="ml-1 text-blue-600 hover:text-blue-800">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </template>
        </div>
        <span class="text-gray-500">▾</span> <!-- Dropdown Arrow -->
    </div>

    <!-- Suggestions List -->
    <div x-show="open && filteredUsers.length > 0" @click.away="open = false"
         class="absolute z-50 w-full mt-1 overflow-auto bg-white border border-gray-300 rounded-md shadow-md max-h-60">
        <!-- Search Input -->
        <input type="text" x-model="search" @input="filterUsers()"
               class="w-full p-2 border-b outline-none" placeholder="Search...">

        <template x-for="user in filteredUsers" :key="user.id">
            <div @click="toggleUser(user)" class="p-2 cursor-pointer hover:bg-gray-100">
                <span x-text="user.name"></span>
            </div>
        </template>
    </div>

    <!-- Hidden Inputs for Form Submission -->
    <template x-for="user in selectedUsers" :key="user.id">
        <input type="hidden" name="month[]" :value="user.name">
    </template>
</div>

<script>
    function userMultiSelect(usersData) {
        return {
            users: usersData,
            selectedUsers: [],
            search: '',
            open: false,
            filteredUsers: usersData,

            filterUsers() {
                const query = this.search.toLowerCase().trim()
                this.filteredUsers = this.users.filter(user => user.name.toLowerCase().includes(query))
            },

            toggleUser(user) {
                const index = this.selectedUsers.findIndex(u => u.id === user.id)
                if (index === -1) {
                    this.selectedUsers.push(user)
                } else {
                    this.selectedUsers.splice(index, 1)
                }
                this.search = ''
                this.filteredUsers = this.users
            },

            removeUser(user) {
                const index = this.selectedUsers.findIndex(u => u.id === user.id)
                if (index !== -1) {
                    this.selectedUsers.splice(index, 1)
                }
            }
        }
    }
</script>
