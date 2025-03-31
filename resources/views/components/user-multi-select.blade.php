<div x-data="userSingleSelect({{ $users->toJson() }})" class="relative w-full">
    <!-- Selected User -->
    <div class="flex items-center justify-between p-1 bg-white border rounded-md cursor-pointer"
         @click="open = !open">
        <span x-text="selectedUser ? selectedUser.name : 'Select a Investor...'" class="text-gray-700"></span>
        <span class="text-gray-500">&#9662;</span> <!-- Dropdown Arrow -->
    </div>

    <!-- Suggestions List -->
    <div x-show="open && filteredUsers.length > 0" @click.away="open = false"
        class="absolute z-50 w-full mt-1 overflow-auto bg-white border rounded-md shadow-md max-h-60">
        <!-- Search Input -->
        <input type="text" x-model="search" @input="filterUsers()"
            class="w-full p-2 border-b outline-none" placeholder="Search...">

        <template x-for="user in filteredUsers" :key="user.id">
            <div @click="selectUser(user)" class="p-2 cursor-pointer hover:bg-gray-100">
                <span x-text="user.name"></span>
            </div>
        </template>
    </div>

    <!-- Hidden Input for Form Submission -->
    <input type="hidden" name="user_id" x-model="selectedUserId" id="user_id">
</div>

<script>
    function userSingleSelect(usersData) {
        return {
            users: usersData,
            selectedUser: null,
            search: '',
            open: false,
            filteredUsers: usersData,

            get selectedUserId() {
                return this.selectedUser ? this.selectedUser.id : '';
            },

            filterUsers() {
                const query = this.search.toLowerCase().trim();
                this.filteredUsers = this.users.filter(user => user.name.toLowerCase().includes(query));
            },

            selectUser(user) {
                this.selectedUser = user;
                this.open = false;
                this.search = ''; // Clear search input
                this.filteredUsers = this.users; // Reset filtered list
            }
        };
    }
</script>
