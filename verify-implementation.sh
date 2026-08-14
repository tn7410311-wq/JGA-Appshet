#!/usr/bin/env bash

# ╔════════════════════════════════════════════════════════════════════════════╗
# ║                 APPSHET-JGA IMPLEMENTATION CHECKLIST                        ║
# ║                                                                            ║
# ║ This checklist helps you verify all changes were implemented correctly    ║
# ╚════════════════════════════════════════════════════════════════════════════╝

echo "🔍 APPSHET-JGA IMPLEMENTATION VERIFICATION"
echo "=========================================="
echo ""

# Color codes
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

check_file() {
    if [ -f "$1" ]; then
        echo -e "${GREEN}✅${NC} $1"
        return 0
    else
        echo -e "${RED}❌${NC} $1 (NOT FOUND)"
        return 1
    fi
}

check_code() {
    if grep -q "$2" "$1" 2>/dev/null; then
        echo -e "${GREEN}✅${NC} $1 contains '$2'"
        return 0
    else
        echo -e "${RED}❌${NC} $1 missing '$2'"
        return 1
    fi
}

echo "📁 CHECKING NEW FILES..."
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"

check_file "app/Mail/UserApprovalRequestMail.php"
check_file "app/Mail/UserApprovalMail.php"
check_file "resources/views/emails/user-approval-request.blade.php"
check_file "resources/views/emails/user-approval.blade.php"
check_file "resources/views/auth/registration-pending.blade.php"
check_file "resources/views/admin/users/approval-panel.blade.php"
check_file "resources/views/appshet-home.blade.php"

echo ""
echo "📝 CHECKING CODE MODIFICATIONS..."
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"

check_code "app/Models/User.php" "is_approved"
check_code "app/Models/User.php" "isApproved"
check_code "app/Http/Controllers/AuthController.php" "isApproved"
check_code "app/Http/Controllers/OtpController.php" "UserApprovalRequestMail"
check_code "app/Http/Controllers/Admin/UserController.php" "approvalPanel"
check_code "config/app.php" "admin_approval_email"

echo ""
echo "🔗 CHECKING ROUTES..."
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"

check_code "routes/web.php" "registration-pending"
check_code "routes/web.php" "users-approval"
check_code "routes/web.php" "users.approve"
check_code "routes/web.php" "users.reject"

echo ""
echo "📚 CHECKING DOCUMENTATION..."
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"

check_file "IMPLEMENTATION_SUMMARY.md"
check_file "QUICK_START.md"
check_file "APPSHET_JGA_SETUP_GUIDE.md"
check_file "IMAGE_PLACEHOLDER_GUIDE.md"
check_file "CODE_CHANGES_REFERENCE.md"
check_file "WORKFLOW_DIAGRAMS.md"

echo ""
echo "⚙️ CHECKING CONFIGURATION..."
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"

if grep -q "admin_approval_email" .env 2>/dev/null; then
    echo -e "${GREEN}✅${NC} .env has admin_approval_email"
else
    echo -e "${YELLOW}⚠️${NC} .env needs: ADMIN_APPROVAL_EMAIL=tn7410311@gmail.com"
fi

echo ""
echo "📸 CHECKING IMAGE LOCATIONS..."
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"

if [ -d "public/images" ]; then
    echo -e "${GREEN}✅${NC} public/images folder exists"
    if [ -f "public/images/hero-background.jpg" ]; then
        echo -e "${GREEN}✅${NC} public/images/hero-background.jpg exists"
    else
        echo -e "${YELLOW}⚠️${NC} public/images/hero-background.jpg (to be added)"
    fi
    if [ -f "public/images/logo.png" ]; then
        echo -e "${GREEN}✅${NC} public/images/logo.png exists"
    else
        echo -e "${YELLOW}⚠️${NC} public/images/logo.png (to be added)"
    fi
else
    echo -e "${YELLOW}⚠️${NC} public/images folder (create and add images)"
fi

echo ""
echo "════════════════════════════════════════════════════════════════════════════"
echo "🎉 IMPLEMENTATION CHECKLIST COMPLETE"
echo "════════════════════════════════════════════════════════════════════════════"
echo ""
echo "📋 NEXT STEPS:"
echo "   1. Run: php artisan migrate"
echo "   2. Create: public/images/ folder"
echo "   3. Add: Hero background, logo, favicon"
echo "   4. Update .env with mail configuration"
echo "   5. Test registration flow"
echo ""
echo "📖 For detailed setup, see:"
echo "   - QUICK_START.md (5 minutes)"
echo "   - APPSHET_JGA_SETUP_GUIDE.md (comprehensive)"
echo "   - IMAGE_PLACEHOLDER_GUIDE.md (where to add images)"
echo ""
echo "✨ HAPPY CODING! 🚀"
