    <footer class="bg-white border-t border-gray-200 mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                
                <div>
                    <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wider mb-4">About</h3>
                    <p class="text-sm text-gray-600">Your university library management system. Explore, borrow, and manage your book collection efficiently.</p>
                </div>

                <div>
                    <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wider mb-4">Quick Links</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('student.books.index') }}" class="text-sm text-gray-600 hover:text-blue-600">Browse Books</a></li>
                        <li><a href="{{ route('student.my-books') }}" class="text-sm text-gray-600 hover:text-blue-600">My Borrowed Books</a></li>
                        <li><a href="{{ route('student.profile.show') }}" class="text-sm text-gray-600 hover:text-blue-600">My Profile</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wider mb-4">Contact</h3>
                    <ul class="space-y-2 text-sm text-gray-600">
                        <li>📧 library@university.edu</li>
                        <li>📞 (123) 456-7890</li>
                        <li>📍 Library Building, Campus</li>
                    </ul>
                </div>
            </div>

            <div class="mt-8 pt-8 border-t border-gray-200">
                <p class="text-center text-sm text-gray-500">&copy; {{ date('Y') }} Library Management System. All rights reserved.</p>
            </div>
        </div>
    </footer>