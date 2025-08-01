<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>All Members - AdminHub</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="dashboard.css">
    <script src="https://unpkg.com/feather-icons"></script>
    <style>
        body {
            margin: 0;
            background: #f6f8fb;
        }
        .dashboard-container {
            display: flex;
            min-height: 100vh;
        }
        .sidebar {
            width: 260px;
            min-width: 220px;
            background: linear-gradient(135deg, #1e4db7 0%, #2563eb 100%);
            color: #fff;
            min-height: 100vh;
            position: relative;
            z-index: 10;
        }
        .main-area {
            flex: 1;
            display: flex;
            flex-direction: column;
            min-width: 0;
        }
        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #fff;
            padding: 0 32px;
            height: 68px;
            border-bottom: 1.5px solid #f0f2f7;
            position: relative;
            z-index: 5;
        }
        .main-content {
            flex: 1;
            padding: 48px 0 0 0;
            display: flex;
            flex-direction: column;
        }
        .members-content-wrapper {
            max-width: 1100px;
            margin: 0 auto;
            padding: 32px 32px 0 32px;
        }
        .members-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: #2563eb;
            margin-bottom: 8px;
        }
        .members-subtitle {
            color: #6b7280;
            font-size: 1.18rem;
            margin-bottom: 32px;
        }
        /* Members Page Styles */
        .members-header-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 18px;
            gap: 18px;
        }
        .members-search-actions {
            display: flex;
            align-items: center;
            gap: 16px;
        }
        .members-search {
            display: flex;
            align-items: center;
            background: #f7fafd;
            border-radius: 24px;
            padding: 0 16px;
            border: 1.5px solid #e6eaf1;
            height: 44px;
            gap: 8px;
        }
        .members-search input {
            border: none;
            background: transparent;
            outline: none;
            font-size: 1.08rem;
            width: 180px;
            padding: 8px 0;
        }
        .add-member-btn {
            background: #2563eb;
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 12px 28px;
            font-size: 1.08rem;
            font-weight: 700;
            cursor: pointer;
            transition: background 0.18s;
        }
        .add-member-btn:hover {
            background: #1741a6;
        }
        .profile-btn {
            background: #4285f4;
            border: none;
            border-radius: 50%;
            width: 44px;
            height: 44px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 1.3rem;
            cursor: pointer;
        }
        .members-section-title {
            font-size: 1.35rem;
            font-weight: 600;
            margin-bottom: 18px;
            color: #222;
        }
        .members-list-card {
            background: #fafcff;
            border-radius: 16px;
            box-shadow: 0 2px 8px 0 rgba(30,77,183,0.04);
            padding: 0;
            max-width: 900px;
            margin-top: 0;
        }
        .members-list-header {
            font-size: 1.13rem;
            font-weight: 600;
            color: #444;
            padding: 22px 28px 12px 28px;
        }
        .members-list-count {
            color: #888;
            font-weight: 400;
            font-size: 1rem;
        }
        #membersList {
            display: flex;
            flex-direction: column;
        }
        .member-row {
            display: flex;
            align-items: center;
            gap: 18px;
            padding: 18px 28px;
            border-top: 1px solid #f0f2f7;
            background: #fff;
            transition: background 0.15s;
        }
        .member-row:nth-child(even) {
            background: #f7fafd;
        }
        .member-avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: #2563eb;
            color: #fff;
            font-weight: 700;
            font-size: 1.15rem;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 6px;
            flex-shrink: 0;
        }
        .member-info {
            flex: 1;
            min-width: 0;
        }
        .member-name {
            font-weight: 600;
            font-size: 1.13rem;
            color: #222;
        }
        .member-email {
            color: #6b7280;
            font-size: 0.98rem;
            word-break: break-all;
        }
        .member-role {
            border-radius: 16px;
            padding: 4px 16px;
            font-size: 0.98rem;
            font-weight: 600;
            margin-right: 10px;
            margin-left: 10px;
            background: #e0e7ff;
            color: #4f46e5;
            border: none;
        }
        .member-role.admin {
            background: #e0e7ff;
            color: #6366f1;
        }
        .member-role.member {
            background: #e0f2fe;
            color: #2563eb;
        }
        .member-role.moderator {
            background: #ede9fe;
            color: #7c3aed;
        }
        .member-action {
            border: none;
            border-radius: 8px;
            padding: 6px 18px;
            font-size: 1rem;
            font-weight: 600;
            margin-left: 6px;
            cursor: pointer;
            transition: background 0.15s;
        }
        .member-action.edit {
            background: #fef9c3;
            color: #b45309;
        }
        .member-action.edit:hover {
            background: #fde047;
        }
        .member-action.delete {
            background: #fee2e2;
            color: #b91c1c;
        }
        .member-action.delete:hover {
            background: #fca5a5;
        }
        @media (max-width: 900px) {
            .members-list-card { max-width: 100%; }
            .main-content { padding: 12px; }
            .members-header-row { flex-direction: column; align-items: flex-start; gap: 10px; }
            .members-search-actions { width: 100%; gap: 10px; }
            .members-search input { width: 100px; }
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <div class="sidebar-logo">
                    <svg width="40" height="40" viewBox="0 0 64 64" fill="none">
                        <rect x="20" y="10" width="24" height="32" rx="12" fill="#fff" opacity="0.1"/>
                        <rect x="28" y="18" width="8" height="20" rx="4" fill="#fff"/>
                        <rect x="24" y="38" width="16" height="4" rx="2" fill="#fff"/>
                        <polygon points="32,54 22,44 42,44" fill="#fff" opacity="0.2"/>
                    </svg>
                </div>
                <span class="sidebar-title">AdminHub</span>
            </div>
            <nav class="sidebar-nav">
                <a href="dashboard.php" class="sidebar-link" id="nav-dashboard"><i data-feather="grid"></i> Dashboard</a>
                <a href="members.php" class="sidebar-link active" id="nav-members"><i data-feather="users"></i> All Members</a>
                <a href="groups.php" class="sidebar-link" id="nav-groups"><i data-feather="layers"></i> Group Info</a>
                <a href="about.php" class="sidebar-link" id="nav-about"><i data-feather="info"></i> About Us</a>
                <a href="contact.php" class="sidebar-link" id="nav-contact"><i data-feather="mail"></i> Contact Us</a>
            </nav>
        </aside>
        <div class="main-area">
            <!-- Topbar -->
            <div class="topbar">
                <div class="topbar-left">
                    <div class="topbar-logo">
                        <svg width="32" height="32" viewBox="0 0 64 64" fill="none">
                            <rect x="20" y="10" width="24" height="32" rx="12" fill="#2563eb" opacity="0.12"/>
                            <rect x="28" y="18" width="8" height="20" rx="4" fill="#2563eb"/>
                            <rect x="24" y="38" width="16" height="4" rx="2" fill="#2563eb"/>
                            <polygon points="32,54 22,44 42,44" fill="#2563eb" opacity="0.18"/>
                        </svg>
                        <span class="topbar-title">All Members</span>
                    </div>
                    <div class="topbar-search">
                        <i data-feather="search"></i>
                        <input type="text" placeholder="Search anything...">
                    </div>
                </div>
                <div class="topbar-actions">
                    <button class="topbar-icon-btn"><i data-feather="bell"></i></button>
                    <button class="topbar-profile"><i data-feather="user"></i></button>
                </div>
            </div>
            <!-- Main Content -->
            <main class="main-content">
                <div class="members-content-wrapper">
                    <div class="members-title">All Members</div>
                    <div class="members-subtitle">View and manage all registered members of your community.</div>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
    <div>
        <button id="deleteSelectedBtn" class="delete-selected-btn" style="background:#ef4444;color:#fff;border:none;border-radius:10px;padding:12px 24px;font-size:1.08rem;font-weight:700;cursor:pointer;display:none;">
            Delete Selected
        </button>
    </div>
    <button id="addMemberBtn" class="add-member-btn" style="background:#2563eb;color:#fff;border:none;border-radius:10px;padding:12px 28px;font-size:1.08rem;font-weight:700;cursor:pointer;">
        Add New Member
    </button>
</div>
                    <!-- Place your member list/table here -->
                    <!-- Example: -->
                    <div class="members-list-card">
                        <div class="members-list-header">
                            Member List <span class="members-list-count">(1,250 total)</span>
                        </div>
                        <div id="membersList">
                            <!-- Members will be loaded dynamically from database -->
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <!-- Add Member Modal -->
    <div id="addMemberModal" style="display:none;position:fixed;top:0;left:0;width:100vw;height:100vh;background:rgba(0,0,0,0.18);z-index:999;align-items:center;justify-content:center;">
        <form id="addMemberForm" style="background:#fff;padding:32px 28px;border-radius:16px;box-shadow:0 2px 8px 0 rgba(30,77,183,0.08);min-width:320px;display:flex;flex-direction:column;gap:16px;">
            <h3 style="margin:0 0 8px 0;color:#2563eb;">Add New Member</h3>
            <input type="text" id="newName" placeholder="Full Name" required style="padding:10px;border-radius:8px;border:1.5px solid #e0e0e0;">
            <input type="email" id="newEmail" placeholder="Email" required style="padding:10px;border-radius:8px;border:1.5px solid #e0e0e0;">
            <select id="newRole" required style="padding:10px;border-radius:8px;border:1.5px solid #e0e0e0;">
                <option value="">Select Role</option>
                <option value="admin">Admin</option>
                <option value="member">Member</option>
                <option value="moderator">Moderator</option>
            </select>
            <div style="display:flex;gap:12px;justify-content:flex-end;">
                <button type="button" id="cancelAddMember" style="background:#f3f4f6;color:#222;border:none;padding:8px 18px;border-radius:8px;cursor:pointer;">Cancel</button>
                <button type="submit" style="background:#2563eb;color:#fff;border:none;padding:8px 18px;border-radius:8px;cursor:pointer;">Add</button>
            </div>
        </form>
    </div>

    <!-- Edit Member Modal -->
    <div id="editMemberModal" style="display:none;position:fixed;top:0;left:0;width:100vw;height:100vh;background:rgba(0,0,0,0.18);z-index:999;align-items:center;justify-content:center;">
        <form id="editMemberForm" style="background:#fff;padding:32px 28px;border-radius:16px;box-shadow:0 2px 8px 0 rgba(30,77,183,0.08);min-width:320px;display:flex;flex-direction:column;gap:16px;">
            <h3 style="margin:0 0 8px 0;color:#2563eb;">Edit Member</h3>
            <input type="hidden" id="editMemberId">
            <input type="text" id="editName" placeholder="Full Name" required style="padding:10px;border-radius:8px;border:1.5px solid #e0e0e0;">
            <input type="email" id="editEmail" placeholder="Email" required style="padding:10px;border-radius:8px;border:1.5px solid #e0e0e0;">
            <select id="editRole" required style="padding:10px;border-radius:8px;border:1.5px solid #e0e0e0;">
                <option value="">Select Role</option>
                <option value="admin">Admin</option>
                <option value="member">Member</option>
                <option value="moderator">Moderator</option>
            </select>
            <div style="display:flex;gap:12px;justify-content:flex-end;">
                <button type="button" id="cancelEditMember" style="background:#f3f4f6;color:#222;border:none;padding:8px 18px;border-radius:8px;cursor:pointer;">Cancel</button>
                <button type="submit" style="background:#2563eb;color:#fff;border:none;padding:8px 18px;border-radius:8px;cursor:pointer;">Update</button>
            </div>
        </form>
    </div>
    <script>
        feather.replace();
        document.getElementById('nav-members').classList.add('active');
        
        // Load members on page load
        loadMembers();
        
        // Modal controls
        document.getElementById('addMemberBtn').onclick = function() {
            document.getElementById('addMemberModal').style.display = 'flex';
        };
        
        document.getElementById('cancelAddMember').onclick = function() {
            document.getElementById('addMemberModal').style.display = 'none';
        };
        
        // Load members from database
        function loadMembers() {
            fetch('members_api.php?action=get_all')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        displayMembers(data.members);
                    } else {
                        console.error('Error loading members:', data.error);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }
        
        // Display members in the list
        function displayMembers(members) {
            const membersList = document.getElementById('membersList');
            membersList.innerHTML = '';
            
            members.forEach(member => {
                const initials = member.name.split(' ').map(w => w[0]).join('').toUpperCase().slice(0, 2);
                const roleClass = member.role === 'admin' ? 'admin' : member.role === 'moderator' ? 'moderator' : 'member';
                const roleLabel = member.role.charAt(0).toUpperCase() + member.role.slice(1);
                
                const row = document.createElement('div');
                row.className = 'member-row';
                row.setAttribute('data-id', member.id);
                row.innerHTML = `
                    <input type="checkbox" class="member-select" style="margin-right:14px;transform:scale(1.2);">
                    <div class="member-avatar" style="background:#4285f4;">${initials}</div>
                    <div class="member-info">
                        <div class="member-name">${member.name}</div>
                        <div class="member-email">${member.email}</div>
                    </div>
                    <span class="member-role ${roleClass}">${roleLabel}</span>
                    <button class="member-action edit" onclick="editMember(${member.id}, '${member.name}', '${member.email}', '${member.role}')">Edit</button>
                    <button class="member-action delete" onclick="deleteMember(${member.id})">Delete</button>
                `;
                membersList.appendChild(row);
            });
            
            updateMemberCount(members.length);
        }
        
        // Update member count
        function updateMemberCount(count) {
            const countElement = document.querySelector('.members-list-count');
            if (countElement) {
                countElement.textContent = `(${count} total)`;
            }
        }
        
        // Function to refresh dashboard stats (if on dashboard page)
        function refreshDashboardStats() {
            // Check if we're on the dashboard page
            if (window.location.pathname.includes('dashboard.php')) {
                // Trigger a custom event that dashboard can listen to
                window.dispatchEvent(new CustomEvent('refreshDashboardStats'));
            }
        }
        
        // Add new member
        document.getElementById('addMemberForm').onsubmit = function(e) {
            e.preventDefault();
            const name = document.getElementById('newName').value.trim();
            const email = document.getElementById('newEmail').value.trim();
            const role = document.getElementById('newRole').value;
            
            if (!name || !email || !role) {
                alert('Please fill in all fields');
                return;
            }
            
            const memberData = {
                name: name,
                email: email,
                role: role
            };
            
            fetch('members_api.php?action=add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(memberData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('addMemberModal').style.display = 'none';
                    this.reset();
                    loadMembers(); // Reload the list
                    refreshDashboardStats(); // Refresh dashboard stats
                    alert('Member added successfully!');
                } else {
                    alert('Error: ' + data.error);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error adding member');
            });
        };
        
        // Delete member
        function deleteMember(memberId) {
            if (confirm('Are you sure you want to delete this member?')) {
                fetch('members_api.php?action=delete', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ id: memberId })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        loadMembers(); // Reload the list
                        refreshDashboardStats(); // Refresh dashboard stats
                        alert('Member deleted successfully!');
                    } else {
                        alert('Error: ' + data.error);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error deleting member');
                });
            }
        }
        
        // Edit member
        function editMember(id, name, email, role) {
            document.getElementById('editMemberId').value = id;
            document.getElementById('editName').value = name;
            document.getElementById('editEmail').value = email;
            document.getElementById('editRole').value = role;
            document.getElementById('editMemberModal').style.display = 'flex';
        }
        
        // Cancel edit modal
        document.getElementById('cancelEditMember').onclick = function() {
            document.getElementById('editMemberModal').style.display = 'none';
        };
        
        // Handle edit form submission
        document.getElementById('editMemberForm').onsubmit = function(e) {
            e.preventDefault();
            const id = document.getElementById('editMemberId').value;
            const name = document.getElementById('editName').value.trim();
            const email = document.getElementById('editEmail').value.trim();
            const role = document.getElementById('editRole').value;
            
            if (!name || !email || !role) {
                alert('Please fill in all fields');
                return;
            }
            
            const memberData = {
                id: id,
                name: name,
                email: email,
                role: role
            };
            
            fetch('members_api.php?action=update', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(memberData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('editMemberModal').style.display = 'none';
                    this.reset();
                    loadMembers(); // Reload the list
                    alert('Member updated successfully!');
                } else {
                    alert('Error: ' + data.error);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error updating member');
            });
        };
        
        // Delete selected members
        function updateDeleteSelectedBtn() {
            const checked = document.querySelectorAll('.member-select:checked').length;
            document.getElementById('deleteSelectedBtn').style.display = checked ? 'inline-block' : 'none';
        }
        
        document.addEventListener('change', function(e) {
            if (e.target.classList.contains('member-select')) {
                updateDeleteSelectedBtn();
            }
        });
        
        document.getElementById('deleteSelectedBtn').onclick = function() {
            const checkedBoxes = document.querySelectorAll('.member-select:checked');
            if (checkedBoxes.length === 0) return;
            
            if (confirm(`Are you sure you want to delete ${checkedBoxes.length} selected member(s)?`)) {
                const memberIds = Array.from(checkedBoxes).map(cb => 
                    parseInt(cb.closest('.member-row').getAttribute('data-id'))
                );
                
                fetch('members_api.php?action=delete_multiple', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ ids: memberIds })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        loadMembers(); // Reload the list
                        alert('Selected members deleted successfully!');
                    } else {
                        alert('Error: ' + data.error);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error deleting members');
                });
            }
        };
    </script>
</body>
</html>