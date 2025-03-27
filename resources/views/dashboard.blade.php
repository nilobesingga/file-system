<x-app-layout>
    <div class="py-2">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <x-dashboard-widget
            :recentUploadsCount="$recentUploadsCount"
            :totalFiles="$totalFiles"
            :amountInvested="$amountInvested"
            :currency="$currency"
            :numberOfBonds="$numberOfBonds"
            :weeklyInvestments="$weeklyInvestments"
            :weeklyBonds="$weeklyBonds"
            :labels="$labels"
            :newFiles="$newFiles"
            />

            <x-files-list :files="$files" :category="$category"/>
        </div>
    </div>
</x-app-layout>

