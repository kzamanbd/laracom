# Multi-Vendor E-commerce Architecture Guide

## Table of Contents

- [Overview](#overview)
- [Current State Analysis](#current-state-analysis)
- [Recommended Directory Structure](#recommended-directory-structure)
- [Core Models Architecture](#core-models-architecture)
- [Livewire Components Organization](#livewire-components-organization)
- [Controller Structure](#controller-structure)
- [Database Design Considerations](#database-design-considerations)
- [Implementation Roadmap](#implementation-roadmap)
- [Best Practices](#best-practices)
- [Security Considerations](#security-considerations)
- [Performance Optimization](#performance-optimization)

## Overview

This document outlines the architectural design for transforming the current Laravel e-commerce application into a large-scale multi-vendor marketplace. The architecture follows Domain-Driven Design (DDD) principles while maintaining Laravel conventions and leveraging Livewire for reactive user interfaces.

### Key Features

- Multi-vendor marketplace with vendor dashboards
- Platform admin controls
- Commission management
- Vendor-specific shipping and policies
- Customer-vendor communication
- Advanced order management
- Financial reporting and payouts

## Current State Analysis

### Existing Strengths

- ✅ Modern Laravel 12 with proper conventions
- ✅ Livewire 3 for reactive components
- ✅ Well-structured e-commerce models
- ✅ Multi-vendor ready User model with vendor fields
- ✅ Comprehensive order and cart system
- ✅ Media management system
- ✅ Proper relationships and factories

### Areas for Enhancement

- 🔄 Extract vendor logic from User model
- 🔄 Implement commission system
- 🔄 Add vendor-specific shipping
- 🔄 Create vendor dashboard components
- 🔄 Implement multi-vendor order processing
- 🔄 Add communication system

## Recommended Directory Structure

### Models Organization (`app/Models/`)

```md
app/Models/
├── Core/                     # Core business entities
│   ├── User.php             # Authentication user
│   ├── Customer.php         # Customer profile
│   └── Address.php          # Address management
├── Vendor/                   # Vendor management
│   ├── Vendor.php           # Vendor entity (extracted from User)
│   ├── VendorProfile.php    # Vendor store settings
│   ├── VendorSubscription.php # Vendor plans/billing
│   ├── VendorSettings.php   # Store configuration
│   ├── VendorDocument.php   # KYC documents
│   └── VendorVerification.php # Verification status
├── Catalog/                  # Product catalog
│   ├── Product.php          # Main product model
│   ├── ProductVariant.php   # Product variations (size, color)
│   ├── Category.php         # Product categories
│   ├── Brand.php            # Product brands
│   ├── Attribute.php        # Product attributes
│   ├── AttributeValue.php   # Attribute values
│   └── ProductAttribute.php # Product-attribute pivot
├── Orders/                   # Order management
│   ├── Order.php            # Main order model
│   ├── OrderItem.php        # Order line items
│   ├── OrderItemTax.php     # Tax calculations
│   ├── OrderStatus.php      # Order status tracking
│   ├── OrderNote.php        # Order notes/comments
│   └── OrderTracking.php    # Shipment tracking
├── Cart/                     # Shopping cart
│   ├── Cart.php             # Shopping cart
│   ├── CartItem.php         # Cart line items
│   ├── Wishlist.php         # Customer wishlist
│   └── WishlistItem.php     # Wishlist items
├── Finance/                  # Financial operations
│   ├── Payment/
│   │   ├── PaymentTransaction.php # Payment records
│   │   ├── PaymentMethod.php      # Payment methods
│   │   ├── PaymentProvider.php    # Payment gateways
│   │   └── Refund.php            # Refund management
│   ├── Commission.php       # Platform commissions
│   ├── VendorPayout.php     # Vendor earnings
│   ├── Invoice.php          # Invoice generation
│   ├── Fee.php              # Platform fees
│   └── Transaction.php      # Financial transactions
├── Shipping/                 # Logistics
│   ├── Shipping.php         # Shipment records
│   ├── ShippingZone.php     # Geographic zones
│   ├── ShippingMethod.php   # Shipping methods
│   ├── ShippingRate.php     # Shipping rates
│   ├── Carrier.php          # Shipping carriers
│   └── TrackingEvent.php    # Tracking events
├── Marketing/                # Marketing features
│   ├── Promotion.php        # Promotional campaigns
│   ├── Coupon.php           # Discount coupons
│   ├── Discount.php         # Discount rules
│   ├── Review.php           # Product reviews
│   ├── Rating.php           # Product ratings
│   └── Banner.php           # Marketing banners
├── Content/                  # Content management
│   ├── Post.php             # Blog posts
│   ├── Page.php             # Static pages
│   ├── Media.php            # Media files
│   ├── Tag.php              # Content tags
│   └── Menu.php             # Navigation menus
├── Communication/            # Messaging system
│   ├── Conversation.php     # Customer-vendor chat
│   ├── Message.php          # Chat messages
│   ├── Notification.php     # System notifications
│   └── Template.php         # Email templates
└── System/                   # System models
    ├── Tax.php              # Tax rules
    ├── Currency.php         # Currency management
    ├── Setting.php          # System settings
    ├── ActivityLog.php      # Activity logging
    ├── Permission.php       # User permissions
    └── Role.php             # User roles
```

### Service Layer (`app/Services/`)

```md
app/Services/
├── Cart/
│   ├── CartService.php              # Cart management
│   ├── CartCalculationService.php   # Price calculations
│   └── CartValidationService.php    # Cart validation
├── Order/
│   ├── OrderService.php             # Order management
│   ├── OrderProcessingService.php   # Order processing
│   ├── OrderNotificationService.php # Order notifications
│   ├── OrderSplittingService.php    # Multi-vendor order splitting
│   └── OrderTrackingService.php     # Order tracking
├── Payment/
│   ├── PaymentService.php           # Payment processing
│   ├── PaymentProviders/
│   │   ├── StripeProvider.php       # Stripe integration
│   │   ├── PayPalProvider.php       # PayPal integration
│   │   └── AbstractProvider.php     # Base provider
│   ├── CommissionService.php        # Commission calculations
│   └── PayoutService.php            # Vendor payouts
├── Vendor/
│   ├── VendorService.php            # Vendor management
│   ├── VendorOnboardingService.php  # Vendor registration
│   ├── VendorVerificationService.php # Vendor verification
│   ├── VendorAnalyticsService.php   # Vendor analytics
│   └── VendorCommissionService.php  # Vendor commission
├── Product/
│   ├── ProductService.php           # Product management
│   ├── InventoryService.php         # Inventory management
│   ├── ProductSearchService.php     # Product search
│   ├── ProductVariantService.php    # Variant management
│   └── ProductRecommendationService.php # Recommendations
├── Shipping/
│   ├── ShippingService.php          # Shipping management
│   ├── ShippingCalculatorService.php # Shipping calculations
│   ├── TrackingService.php          # Package tracking
│   └── CarrierIntegrationService.php # Carrier APIs
├── Finance/
│   ├── CommissionCalculatorService.php # Commission calculations
│   ├── PayoutCalculatorService.php     # Payout calculations
│   ├── InvoiceService.php              # Invoice generation
│   └── TaxCalculatorService.php        # Tax calculations
├── Communication/
│   ├── NotificationService.php      # Notification management
│   ├── EmailService.php             # Email sending
│   ├── SmsService.php               # SMS sending
│   └── ChatService.php              # Chat management
└── Analytics/
    ├── SalesAnalyticsService.php    # Sales analytics
    ├── VendorAnalyticsService.php   # Vendor analytics
    ├── CustomerAnalyticsService.php # Customer analytics
    └── ReportingService.php         # Report generation
```

## Core Models Architecture

### Vendor Model Design

```php
// app/Models/Vendor/Vendor.php
class Vendor extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'store_name',
        'store_slug',
        'store_description',
        'store_logo',
        'store_banner',
        'company_name',
        'tax_id',
        'phone',
        'email',
        'website',
        'status', // pending, active, suspended, rejected
        'commission_rate',
        'meta',
    ];

    protected function casts(): array
    {
        return [
            'meta' => 'array',
            'commission_rate' => 'decimal:2',
            'verified_at' => 'datetime',
        ];
    }

    // Relationships
    public function user(): BelongsTo
    public function products(): HasMany
    public function orders(): HasMany
    public function payouts(): HasMany
    public function settings(): HasOne
    public function subscription(): HasOne
    public function addresses(): MorphMany
    public function media(): MorphMany
}
```

### Multi-Vendor Order Processing

```php
// app/Models/Orders/Order.php
class Order extends Model
{
    // New fields for multi-vendor support
    protected $fillable = [
        // ... existing fields
        'vendor_id',           // Primary vendor (for single vendor orders)
        'is_multi_vendor',     // Flag for multi-vendor orders
        'parent_order_id',     // For split orders
        'split_from_order_id', // Reference to original order
    ];

    // Vendor relationship
    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

    // Child orders for multi-vendor splits
    public function childOrders(): HasMany
    {
        return $this->hasMany(Order::class, 'parent_order_id');
    }

    // Parent order for split orders
    public function parentOrder(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'parent_order_id');
    }
}
```

## Livewire Components Organization

### Vendor Dashboard Structure

```md
app/Livewire/Vendor/
├── Dashboard/
│   ├── Overview.php              # Dashboard overview
│   ├── Analytics.php             # Sales analytics
│   ├── QuickStats.php            # Quick statistics
│   └── RecentActivity.php        # Recent activities
├── Products/
│   ├── ProductList.php           # Product listing
│   ├── ProductForm.php           # Product create/edit
│   ├── ProductVariants.php       # Variant management
│   ├── Inventory.php             # Inventory management
│   ├── BulkActions.php           # Bulk operations
│   └── ProductImport.php         # CSV import
├── Orders/
│   ├── OrderList.php             # Order listing
│   ├── OrderDetail.php           # Order details
│   ├── OrderFulfillment.php      # Order fulfillment
│   ├── OrderTracking.php         # Order tracking
│   └── OrderNotes.php            # Order notes
├── Finance/
│   ├── Earnings.php              # Earnings overview
│   ├── Payouts.php               # Payout history
│   ├── Commissions.php           # Commission details
│   ├── Invoices.php              # Invoice management
│   └── Reports.php               # Financial reports
├── Customers/
│   ├── CustomerList.php          # Customer list
│   ├── CustomerDetail.php        # Customer details
│   └── CustomerMessages.php      # Customer communication
├── Marketing/
│   ├── Promotions.php            # Promotional campaigns
│   ├── Coupons.php               # Coupon management
│   ├── Reviews.php               # Review management
│   └── Analytics.php             # Marketing analytics
├── Shipping/
│   ├── ShippingZones.php         # Shipping zones
│   ├── ShippingRates.php         # Shipping rates
│   ├── CarrierSettings.php       # Carrier configuration
│   └── TrackingManager.php       # Tracking management
└── Settings/
    ├── StoreProfile.php          # Store profile
    ├── BusinessInfo.php          # Business information
    ├── PaymentSettings.php       # Payment configuration
    ├── ShippingSettings.php      # Shipping configuration
    ├── TaxSettings.php           # Tax configuration
    ├── Policies.php              # Store policies
    └── Preferences.php           # User preferences
```

### Admin Dashboard Structure

```md
app/Livewire/Admin/
├── Dashboard/
│   ├── Overview.php              # Admin overview
│   ├── Analytics.php             # Platform analytics
│   └── SystemHealth.php          # System monitoring
├── Vendors/
│   ├── VendorList.php            # Vendor management
│   ├── VendorDetail.php          # Vendor details
│   ├── VendorVerification.php    # Vendor verification
│   ├── VendorOnboarding.php      # Onboarding process
│   └── VendorCommissions.php     # Commission management
├── Orders/
│   ├── OrderList.php             # All orders
│   ├── OrderDetail.php           # Order details
│   ├── OrderDisputes.php         # Order disputes
│   └── OrderReports.php          # Order reporting
├── Finance/
│   ├── TransactionList.php       # All transactions
│   ├── PayoutManagement.php      # Payout processing
│   ├── CommissionReports.php     # Commission reports
│   ├── TaxReports.php            # Tax reporting
│   └── FinancialDashboard.php    # Financial overview
├── Products/
│   ├── ProductModeration.php     # Product approval
│   ├── CategoryManagement.php    # Category management
│   ├── BrandManagement.php       # Brand management
│   └── AttributeManagement.php   # Attribute management
├── Users/
│   ├── CustomerList.php          # Customer management
│   ├── AdminList.php             # Admin users
│   ├── RoleManagement.php        # Role management
│   └── PermissionManagement.php  # Permission management
├── Settings/
│   ├── PlatformSettings.php      # Platform configuration
│   ├── PaymentGateways.php       # Payment gateways
│   ├── EmailSettings.php         # Email configuration
│   ├── TaxSettings.php           # Tax configuration
│   └── IntegrationSettings.php   # Third-party integrations
└── Reports/
    ├── SalesReports.php          # Sales reporting
    ├── VendorReports.php         # Vendor reporting
    ├── CustomerReports.php       # Customer reporting
    └── FinancialReports.php      # Financial reporting
```

## Controller Structure

### API Controllers for Mobile/Third-party Integration

```md
app/Http/Controllers/Api/V1/
├── Auth/
│   ├── AuthController.php        # Authentication
│   ├── RegisterController.php    # User registration
│   └── VendorRegistrationController.php # Vendor registration
├── Products/
│   ├── ProductController.php     # Product CRUD
│   ├── CategoryController.php    # Category management
│   ├── SearchController.php      # Product search
│   └── ReviewController.php      # Product reviews
├── Orders/
│   ├── OrderController.php       # Order management
│   ├── CartController.php        # Cart operations
│   └── CheckoutController.php    # Checkout process
├── Vendors/
│   ├── VendorController.php      # Vendor operations
│   ├── VendorProductController.php # Vendor products
│   └── VendorOrderController.php   # Vendor orders
├── Customers/
│   ├── ProfileController.php     # Customer profile
│   ├── AddressController.php     # Address management
│   └── WishlistController.php    # Wishlist operations
└── Payments/
    ├── PaymentController.php     # Payment processing
    └── WebhookController.php     # Payment webhooks
```

## Database Design Considerations

### Key Tables to Add/Modify

```sql
-- Vendor table (extract from users)
vendors
├── id
├── user_id (FK)
├── store_name
├── store_slug
├── store_description
├── company_name
├── tax_id
├── commission_rate
├── status (pending, active, suspended, rejected)
├── verified_at
└── timestamps

-- Vendor subscriptions
vendor_subscriptions
├── id
├── vendor_id (FK)
├── plan_name
├── plan_price
├── billing_cycle
├── features (JSON)
├── starts_at
├── ends_at
└── timestamps

-- Commission tracking
commissions
├── id
├── order_id (FK)
├── vendor_id (FK)
├── order_total
├── commission_rate
├── commission_amount
├── platform_fee
├── status (pending, paid, disputed)
└── timestamps

-- Vendor payouts
vendor_payouts
├── id
├── vendor_id (FK)
├── payout_period_start
├── payout_period_end
├── total_sales
├── total_commission
├── platform_fees
├── net_amount
├── status (pending, processed, failed)
├── processed_at
└── timestamps

-- Multi-vendor order items
order_items (modify existing)
├── id
├── order_id (FK)
├── product_id (FK)
├── vendor_id (FK) -- NEW
├── vendor_commission_rate -- NEW
├── vendor_commission_amount -- NEW
├── platform_fee_amount -- NEW
└── existing fields...

-- Conversations
conversations
├── id
├── customer_id (FK)
├── vendor_id (FK)
├── order_id (FK) [optional]
├── subject
├── status (open, closed, resolved)
└── timestamps

-- Messages
messages
├── id
├── conversation_id (FK)
├── sender_type (customer, vendor, admin)
├── sender_id
├── message
├── attachments (JSON)
├── read_at
└── timestamps
```

## Implementation Roadmap

### Phase 1: Foundation (Weeks 1-2)

1. **Extract Vendor Logic**
   - Create Vendor model
   - Migrate vendor data from User model
   - Update relationships

2. **Basic Vendor Dashboard**
   - Create vendor authentication
   - Basic dashboard layout
   - Product management

### Phase 2: Core Multi-Vendor Features (Weeks 3-4)

1. **Multi-Vendor Order Processing**
   - Order splitting by vendor
   - Vendor-specific order management
   - Commission calculation

2. **Financial System**
   - Commission tracking
   - Basic payout system
   - Transaction logging

### Phase 3: Advanced Features (Weeks 5-6)

1. **Vendor-Specific Shipping**
   - Shipping zones by vendor
   - Vendor shipping rates
   - Multi-vendor shipping calculations

2. **Communication System**
   - Customer-vendor messaging
   - Order-related communication
   - Notification system

### Phase 4: Admin & Analytics (Weeks 7-8)

1. **Admin Dashboard**
   - Vendor management
   - Order oversight
   - Financial reporting

2. **Analytics & Reporting**
   - Vendor analytics
   - Sales reporting
   - Commission reporting

### Phase 5: Optimization & Polish (Weeks 9-10)

1. **Performance Optimization**
   - Database optimization
   - Caching strategies
   - API rate limiting

2. **Testing & Documentation**
   - Comprehensive testing
   - API documentation
   - User documentation

## Best Practices

### Code Organization

- Use service classes for complex business logic
- Implement repository pattern for data access
- Use form request classes for validation
- Implement resource classes for API responses

### Database Best Practices

- Use proper indexing for performance
- Implement soft deletes for important data
- Use database transactions for data integrity
- Regular database backups

### Security Best Practices

- Implement proper authorization policies
- Use middleware for role-based access
- Sanitize all user inputs
- Regular security audits

### Performance Optimization

- Implement Redis for caching
- Use database query optimization
- Implement proper pagination
- Use lazy loading for relationships

## Security Considerations

### Vendor Isolation

```php
// Ensure vendors can only access their own data
class VendorPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole('admin');
    }

    public function view(User $user, Vendor $vendor): bool
    {
        return $user->id === $vendor->user_id || $user->hasRole('admin');
    }

    public function update(User $user, Vendor $vendor): bool
    {
        return $user->id === $vendor->user_id;
    }
}
```

### Multi-Tenant Data Security

- Implement proper authorization policies
- Use database-level constraints
- Audit trail for sensitive operations
- Regular security assessments

## Performance Optimization [TODO]

### Database Optimization

```php
// Example: Optimize vendor dashboard queries
class VendorDashboardService
{
    public function getDashboardData(Vendor $vendor): array
    {
        return [
            'stats' => $this->getVendorStats($vendor),
            'recent_orders' => $this->getRecentOrders($vendor),
            'top_products' => $this->getTopProducts($vendor),
        ];
    }

    private function getVendorStats(Vendor $vendor): array
    {
        return Cache::remember("vendor.{$vendor->id}.stats", 3600, function () use ($vendor) {
            return [
                'total_sales' => $vendor->orders()->sum('total'),
                'total_orders' => $vendor->orders()->count(),
                'pending_orders' => $vendor->orders()->where('status', 'pending')->count(),
            ];
        });
    }
}
```

### Caching Strategy

- Cache vendor statistics
- Cache product catalog data
- Cache shipping calculations
- Cache commission calculations

### Queue Implementation

```php
// Example: Process vendor payouts in background
class ProcessVendorPayouts implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(PayoutService $payoutService): void
    {
        $vendors = Vendor::where('status', 'active')->get();
        
        foreach ($vendors as $vendor) {
            $payoutService->calculateAndCreatePayout($vendor);
        }
    }
}
```

---

## Conclusion

This architecture provides a solid foundation for building a large-scale multi-vendor e-commerce platform. The modular design allows for incremental development and scaling, while maintaining code quality and performance.

Key benefits:

- **Scalable**: Domain-based organization supports team growth
- **Maintainable**: Clear separation of concerns
- **Testable**: Service layer enables comprehensive testing
- **Flexible**: Modular design supports feature additions
- **Secure**: Built-in security considerations
- **Performant**: Optimization strategies included

Follow the implementation roadmap to build features incrementally, ensuring each phase is thoroughly tested before moving to the next.
