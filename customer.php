<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>NexusGadgets Online Store</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: linear-gradient(135deg, #0a192f 0%, #172a45 100%);
            color: white;
            min-height: 100vh;
        }

        /* Header styles */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 5%;
            background: rgba(10, 25, 47, 0.7);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .logo img {
            width: 40px;
            height: 40px;
        }

        .logo-text {
            font-size: 24px;
            font-weight: bold;
            color: #6366f1;
            text-shadow: 0 0 10px rgba(99, 102, 241, 0.5);
        }

        .nav-links {
            display: flex;
            gap: 30px;
        }

        .nav-link {
            color: #ccd6f6;
            text-decoration: none;
            font-size: 16px;
            transition: all 0.3s;
            position: relative;
        }

        .nav-link:hover {
            color: #6366f1;
        }

        .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 100%;
            height: 2px;
            background: #6366f1;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .search-bar {
            display: flex;
            align-items: center;
            background: rgba(23, 42, 69, 0.8);
            border-radius: 25px;
            padding: 8px 15px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(99, 102, 241, 0.2);
        }

        .search-bar input {
            border: none;
            outline: none;
            background: transparent;
            color: white;
            padding: 0 10px;
            font-size: 14px;
            width: 200px;
        }

        .search-bar input::placeholder {
            color: rgba(255,255,255,0.5);
        }

        .cart-icon, .profile-icon {
            position: relative;
            cursor: pointer;
        }

        .cart-count {
            position: absolute;
            top: -8px;
            right: -8px;
            background: #6366f1;
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: bold;
        }

        /* Profile dropdown */
        .profile-dropdown {
            position: absolute;
            top: 50px;
            right: 0;
            background: linear-gradient(135deg, #172a45 0%, #0a192f 100%);
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
            width: 220px;
            padding: 15px;
            display: none;
            z-index: 1001;
            border: 1px solid rgba(99, 102, 241, 0.2);
        }

        .profile-dropdown.active {
            display: block;
        }

        .profile-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid rgba(99, 102, 241, 0.2);
        }

        .profile-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #6366f1;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        .profile-name {
            font-size: 14px;
            font-weight: bold;
        }

        .profile-email {
            font-size: 12px;
            color: rgba(204, 214, 246, 0.7);
        }

        .profile-menu {
            list-style: none;
        }

        .profile-menu li {
            margin-bottom: 8px;
        }

        .profile-menu a {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #ccd6f6;
            text-decoration: none;
            font-size: 14px;
            padding: 8px 5px;
            border-radius: 5px;
            transition: all 0.3s;
        }

        .profile-menu a:hover {
            background: rgba(99, 102, 241, 0.2);
            color: #6366f1;
        }

        .profile-menu i {
            width: 20px;
            text-align: center;
        }

        /* Hero section */
        .hero {
            padding: 60px 5%;
            text-align: center;
            background: linear-gradient(135deg, rgba(10, 25, 47, 0.8) 0%, rgba(23, 42, 69, 0.8) 100%);
            margin-bottom: 40px;
        }

        .hero h1 {
            font-size: 48px;
            margin-bottom: 20px;
            color: #6366f1;
            text-shadow: 0 0 15px rgba(99, 102, 241, 0.5);
        }

        .hero p {
            font-size: 18px;
            color: #ccd6f6;
            max-width: 700px;
            margin: 0 auto 30px;
        }

        .cta-button {
            padding: 12px 30px;
            background: linear-gradient(135deg, #6366f1 0%, #1e4b8e 100%);
            color: white;
            border: none;
            border-radius: 30px;
            font-weight: bold;
            cursor: pointer;
            font-size: 16px;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3);
        }

        .cta-button:hover {
            background: linear-gradient(135deg, #1e4b8e 0%, #6366f1 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(99, 102, 241, 0.4);
        }

        /* Categories */
        .categories-container {
            display: flex;
            justify-content: center;
            width: 100%;
            padding: 0 5% 20px;
        }

        .categories {
            display: flex;
            gap: 15px;
            overflow-x: auto;
            scrollbar-width: none;
            justify-content: center;
        }

        .categories::-webkit-scrollbar {
            display: none;
        }

        .category {
            background: linear-gradient(135deg, #1e4b8e 0%, #0a192f 100%);
            color: #FFFFFF;
            padding: 12px 25px;
            border-radius: 30px;
            white-space: nowrap;
            cursor: pointer;
            font-size: 14px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(99, 102, 241, 0.2);
            transition: all 0.3s;
        }

        .category.active {
            background: linear-gradient(135deg, #6366f1 0%, #1e4b8e 100%);
            color: white;
            font-weight: bold;
            box-shadow: 0 0 15px rgba(99, 102, 241, 0.5);
            transform: translateY(-2px);
        }

        .category:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(99, 102, 241, 0.3);
        }

        /* Products grid */
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 25px;
            padding: 0 5% 40px;
        }

        .product-card {
            background: linear-gradient(135deg, #172a45 0%, #0a192f 100%);
            color: #FFFFFF;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            transition: all 0.3s;
            display: flex;
            flex-direction: column;
            height: 100%;
            border: 1px solid rgba(99, 102, 241, 0.1);
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(99, 102, 241, 0.2);
            border: 1px solid rgba(99, 102, 241, 0.3);
        }

        .product-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-bottom: 1px solid rgba(99, 102, 241, 0.1);
        }

        .product-details {
            padding: 20px;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
}

        .product-name {
            font-size: 18px;
            margin-bottom: 10px;
            color: #ccd6f6;
        }

        .product-description {
            font-size: 14px;
            color: rgba(204, 214, 246, 0.7);
            margin-bottom: 15px;
            flex-grow: 1;
        }

        .product-price {
            font-size: 20px;
            font-weight: bold;
            color: #6366f1;
            margin-bottom: 15px;
        }

        .product-rating {
            display: flex;
            align-items: center;
            gap: 5px;
            margin-bottom: 15px;
            color: #ffd700;
        }

        .product-actions {
            display: flex;
            gap: 10px;
            margin-top: auto;
        }

        .add-to-cart {
            flex: 1;
            padding: 10px;
            background: linear-gradient(135deg, #1e4b8e 0%, #6366f1 100%);
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            transition: all 0.3s;
        }

        .add-to-cart:hover {
            background: linear-gradient(135deg, #6366f1 0%, #1e4b8e 100%);
        }

        .wishlist-btn {
            width: 40px;
            height: 40px;
            border-radius: 5px;
            background: rgba(30, 75, 142, 0.5);
            color: white;
            border: none;
            cursor: pointer;
            transition: all 0.3s;
        }

        .wishlist-btn:hover {
            background: rgba(255, 107, 107, 0.7);
            color: white;
        }

        /* Featured section */
        .featured-section {
            padding: 60px 5%;
            background: linear-gradient(135deg, rgba(10, 25, 47, 0.8) 0%, rgba(23, 42, 69, 0.8) 100%);
            margin: 40px 0;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .section-title {
            font-size: 28px;
            color: #6366f1;
            text-shadow: 0 0 10px rgba(99, 102, 241, 0.5);
        }

        .view-all {
            color: #ccd6f6;
            text-decoration: none;
            font-size: 16px;
            transition: all 0.3s;
        }

        .view-all:hover {
            color: #6366f1;
        }

        /* Cart sidebar */
        .cart-sidebar {
            position: fixed;
            top: 0;
            right: -400px;
            width: 400px;
            height: 100vh;
            background: linear-gradient(135deg, #0a192f 0%, #172a45 100%);
            box-shadow: -5px 0 15px rgba(0, 0, 0, 0.3);
            z-index: 1001;
            transition: right 0.3s ease;
            display: flex;
            flex-direction: column;
        }

        .cart-sidebar.open {
            right: 0;
        }

        .cart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            border-bottom: 1px solid rgba(99, 102, 241, 0.2);
        }

        .cart-title {
            font-size: 24px;
            color: #6366f1;
        }

        .close-cart {
            background: none;
            border: none;
            color: #ccd6f6;
            font-size: 24px;
            cursor: pointer;
        }

        .cart-items {
            flex-grow: 1;
            overflow-y: auto;
            padding: 20px;
        }

        .cart-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid rgba(99, 102, 241, 0.1);
        }

        .cart-item-info {
            display: flex;
            align-items: center;
            gap: 15px;
            flex: 1;
        }

        .cart-item-image {
            width: 60px;
            height: 60px;
            border-radius: 8px;
            object-fit: cover;
        }

        .cart-item-details {
            display: flex;
            flex-direction: column;
        }

        .cart-item-name {
            font-size: 16px;
            color: #ccd6f6;
            margin-bottom: 5px;
        }

        .cart-item-price {
            font-size: 14px;
            color: #6366f1;
        }

        .cart-item-controls {
            display: flex;
            align-items: center;
            gap: 5px;
}

        .qty-btn {
            width: 25px;
            height: 25px;
            border-radius: 5px;
            background: #1e4b8e;
            color: white;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .qty-btn:hover {
            background: #6366f1;
        }

        .cart-item-qty {
            margin: 0 5px;
            font-size: 14px;
        }

        .remove-btn {
            background: none;
            border: none;
            color: #ff6b6b;
            cursor: pointer;
            font-size: 16px;
        }

        .cart-summary {
            padding: 20px;
            border-top: 1px solid rgba(99, 102, 241, 0.2);
        }

        .cart-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-size: 14px;
        }

        .cart-total {
            font-weight: bold;
            font-size: 16px;
            color: #6366f1;
        }

        .checkout-btn {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #6366f1 0%, #1e4b8e 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 15px;
            transition: all 0.3s;
        }

        .checkout-btn:hover {
            background: linear-gradient(135deg, #1e4b8e 0%, #6366f1 100%);
            box-shadow: 0 0 15px rgba(99, 102, 241, 0.5);
        }

        /* Checkout Modal */
        .checkout-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1002;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .checkout-modal.active {
            opacity: 1;
            visibility: visible;
        }

        .checkout-container {
            background: linear-gradient(135deg, #0a192f 0%, #172a45 100%);
            border-radius: 15px;
            width: 90%;
            max-width: 1000px;
            max-height: 90vh;
            overflow-y: auto;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            transform: translateY(20px);
            transition: transform 0.3s ease;
        }

        .checkout-modal.active .checkout-container {
            transform: translateY(0);
        }

        .checkout-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .checkout-title {
            font-size: 32px;
            color: #6366f1;
            margin-bottom: 10px;
        }

        .checkout-steps {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-bottom: 30px;
        }

        .checkout-step {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 5px;
        }

        .step-number {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #172a45;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            border: 2px solid #6366f1;
        }

        .step-number.active {
            background: #6366f1;
            color: white;
        }

        .step-name {
            font-size: 14px;
            color: #ccd6f6;
        }

        .checkout-grid {
            display: grid;
            grid-template-columns: 1fr 350px;
            gap: 30px;
        }

        .checkout-section {
            background: linear-gradient(135deg, #172a45 0%, #0a192f 100%);
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 20px;
            border: 1px solid rgba(99, 102, 241, 0.2);
        }

        .section-title {
            font-size: 20px;
            color: #6366f1;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-label {
            display: block;
            margin-bottom: 5px;
            font-size: 14px;
            color: #ccd6f6;
        }

        .form-input {
            width: 100%;
            padding: 10px 15px;
            background: rgba(23, 42, 69, 0.5);
            border: 1px solid rgba(99, 102, 241, 0.3);
            border-radius: 5px;
            color: white;
            font-size: 14px;
        }

        .form-input:focus {
            outline: none;
            border-color: #6366f1;
        }

        .checkout-actions {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
        }

        .back-btn, .continue-btn {
            padding: 12px 25px;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s;
        }

        .back-btn {
            background: transparent;
            border: 1px solid #6366f1;
            color: #6366f1;
        }

        .back-btn:hover {
            background: rgba(99, 102, 241, 0.1);
        }

        .continue-btn {
            background: linear-gradient(135deg, #6366f1 0%, #1e4b8e 100%);
            color: white;
            border: none;
        }

        .continue-btn:hover {
            background: linear-gradient(135deg, #1e4b8e 0%, #6366f1 100%);
        }

        /* Order Summary */
        .order-summary {
            position: sticky;
            top: 20px;
        }

        .summary-title {
            font-size: 20px;
            color: #6366f1;
            margin-bottom: 20px;
        }

        .summary-items {
            margin-bottom: 20px;
            max-height: 300px;
            overflow-y: auto;
        }

        .summary-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px solid rgba(99, 102, 241, 0.1);
        }

        .item-name {
            font-size: 14px;
            color: #ccd6f6;
        }

        .item-price {
            font-size: 14px;
            color: #6366f1;
        }

        .summary-total {
            display: flex;
            justify-content: space-between;
            font-weight: bold;
            font-size: 16px;
            color: #6366f1;
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid rgba(99, 102, 241, 0.2);
        }

        /* Payment Methods */
        .payment-methods {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .payment-method {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px;
            background: rgba(23, 42, 69, 0.5);
            border-radius: 5px;
            cursor: pointer;
            border: 1px solid transparent;
            transition: all 0.3s;
        }

        .payment-method:hover {
            border-color: #6366f1;
        }

        .payment-method.active {
            border-color: #6366f1;
            background: rgba(99, 102, 241, 0.1);
        }

        .payment-icon {
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(99, 102, 241, 0.2);
            border-radius: 5px;
        }

        .payment-name {
            font-size: 14px;
            color: #ccd6f6;
        }

        /* Order Confirmation */
        .order-confirmation {
            text-align: center;
            padding: 40px 5%;
            max-width: 800px;
            margin: 0 auto;
            display: none;
        }

        .confirmation-icon {
            font-size: 80px;
            color: #4ade80;
            margin-bottom: 20px;
        }

        .confirmation-title {
            font-size: 32px;
            color: #6366f1;
            margin-bottom: 15px;
        }

        .confirmation-text {
            font-size: 16px;
            color: #ccd6f6;
            margin-bottom: 30px;
            line-height: 1.6;
        }

        .order-details {
            background: linear-gradient(135deg, #172a45 0%, #0a192f 100%);
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 30px;
            text-align: left;
            border: 1px solid rgba(99, 102, 241, 0.2);
        }

        .order-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-size: 14px;
        }

        .order-label {
            color: #ccd6f6;
        }

        .order-value {
            color: #6366f1;
            font-weight: bold;
        }

        .print-btn, .track-btn {
            padding: 12px 25px;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s;
            margin: 0 10px;
        }

        .print-btn {
            background: linear-gradient(135deg, #6366f1 0%, #1e4b8e 100%);
            color: white;
            border: none;
        }

        .print-btn:hover {
            background: linear-gradient(135deg, #1e4b8e 0%, #6366f1 100%);
        }

        .track-btn {
            background: transparent;
            border: 1px solid #6366f1;
            color: #6366f1;
        }

        .track-btn:hover {
            background: rgba(99, 102, 241, 0.1);
        }

        /* Delivery Tracking */
        .tracking-container {
            display: none;
            padding: 40px 5%;
            max-width: 800px;
            margin: 0 auto;
        }

        .tracking-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .tracking-title {
            font-size: 32px;
            color: #6366f1;
            margin-bottom: 10px;
        }

        .tracking-steps {
            position: relative;
            padding: 40px 0;
            margin-bottom: 30px;
        }

        .tracking-line {
            position: absolute;
            top: 0;
            left: 50px;
            width: 3px;
            height: 100%;
            background: #172a45;
            transform: translateX(-50%);
        }

        .tracking-line-progress {
            position: absolute;
            top: 0;
            left: 50px;
            width: 3px;
            height: 50%;
            background: #6366f1;
            transform: translateX(-50%);
            transition: height 0.5s ease;
        }

        .tracking-step {
            display: flex;
            gap: 20px;
            margin-bottom: 40px;
            position: relative;
        }

        .tracking-step:last-child {
            margin-bottom: 0;
        }

        .step-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #172a45;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            color: #6366f1;
            border: 2px solid #6366f1;
            z-index: 1;
        }

        .step-icon.active {
            background: #6366f1;
            color: white;
        }

        .step-details {
            flex: 1;
        }

        .step-title {
            font-size: 18px;
            color: #ccd6f6;
            margin-bottom: 5px;
        }

        .step-description {
            font-size: 14px;
            color: rgba(204, 214, 246, 0.7);
        }

        .step-date {
            font-size: 12px;
            color: #6366f1;
            margin-top: 5px;
        }

        .tracking-map {
            width: 100%;
            height: 300px;
            background: #172a45;
            border-radius: 10px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ccd6f6;
            border: 1px solid rgba(99, 102, 241, 0.2);
        }

        .tracking-actions {
            display: flex;
            justify-content: center;
            gap: 15px;
        }

        /* Overlay */
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            display: none;
        }

        .overlay.active {
            display: block;
        }

        /* Footer */
        .footer {
            background: linear-gradient(135deg, #0a192f 0%, #172a45 100%);
            padding: 40px 5%;
            color: #ccd6f6;
        }

        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 30px;
            margin-bottom: 30px;
        }

        .footer-column h3 {
            font-size: 18px;
            color: #6366f1;
            margin-bottom: 15px;
            font-weight: bold;
        }

        .footer-column ul {
            list-style: none;
        }

        .footer-column li {
            margin-bottom: 10px;
        }

        .footer-column a {
            color: #ccd6f6;
            text-decoration: none;
            transition: all 0.3s;
        }

        .footer-column a:hover {
            color: #6366f1;
        }

        .social-links {
            display: flex;
            gap: 15px;
        }

        .social-link {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(30, 75, 142, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
        }

        .social-link:hover {
            background: #6366f1;
            transform: translateY(-3px);
        }

        .footer-bottom {
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid rgba(99, 102, 241, 0.2);
            font-size: 14px;
        }

        /* Add to cart notification */
        .add-to-cart-notification {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: rgba(10, 25, 47, 0.9);
            color: white;
            padding: 15px 25px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            transform: translateY(100px);
            opacity: 0;
            transition: all 0.3s ease;
            z-index: 1002;
        }

        .add-to-cart-notification.show {
            transform: translateY(0);
            opacity: 1;
        }

        .add-to-cart-notification i {
            color: #4ade80;
        }

        /* Featured badge */
        .featured-badge {
            position: absolute;
            top: 10px;
            left: 10px;
            background: #6366f1;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 12px;
            font-weight: bold;
            z-index: 1;
        }

        /* Old price */
        .old-price {
            text-decoration: line-through;
            color: rgba(204, 214, 246, 0.5);
            font-size: 16px;
            margin-left: 5px;
        }

        /* Responsive adjustments */
        @media (max-width: 1024px) {
            .products-grid {
                grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            }
            
            .cart-sidebar {
                width: 350px;
            }

            .checkout-grid {
                grid-template-columns: 1fr;
            }

            .order-summary {
                position: static;
            }
        }

        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                gap: 15px;
                padding: 15px;
            }
            
            .nav-links {
                gap: 15px;
            }
            
            .search-bar input {
                width: 150px;
            }
            
            .products-grid {
                grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
                gap: 15px;
            }
            
            .cart-sidebar {
                width: 300px;
            }
            
            .hero h1 {
                font-size: 36px;
            }
            
            .hero p {
                font-size: 16px;
            }

            .checkout-steps {
                flex-wrap: wrap;
            }

            .checkout-step {
                width: 100px;
            }
        }

        @media (max-width: 576px) {
            .nav-links {
                display: none;
            }
            
            .search-bar {
                width: 100%;
            }
            
            .search-bar input {
                width: 100%;
            }
            
            .products-grid {
                grid-template-columns: 1fr;
            }
            
            .cart-sidebar {
                width: 100%;
            }
            
            .hero h1 {
                font-size: 28px;
            }

            .checkout-step {
                width: 80px;
            }

            .checkout-actions {
                flex-direction: column;
                gap: 10px;
            }

            .back-btn, .continue-btn {
                width: 100%;
            }

            .print-btn, .track-btn {
                width: 100%;
                margin: 5px 0;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="logo">
            <img src="https://via.placeholder.com/40x40?text=NG" alt="NexusGadgets Logo">
            <span class="logo-text">NexusGadgets</span>
        </div>
        
        <nav class="nav-links">
            <a href="#" class="nav-link active">Home</a>
            <a href="#categories-section" class="nav-link" id="shop-link">Shop</a>
            <a href="#" class="nav-link">Deals</a>
            <a href="#" class="nav-link">About</a>
        </nav>
        
        <div class="header-actions">
            <div class="search-bar">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Search products...">
            </div>
            
            <div class="cart-icon" id="cart-icon">
                <i class="fas fa-shopping-cart"></i>
                <span class="cart-count" id="cart-count">0</span>
            </div>

            <div class="profile-icon" id="profile-icon">
                <i class="fas fa-user-circle"></i>
                <div class="profile-dropdown" id="profile-dropdown">
                    <div class="profile-header">
                        <div class="profile-avatar">JD</div>
                        <div>
                            <div class="profile-name">John Doe</div>
            <div class="profile-email">john.doe@example.com</div>
        </div>
    </div>
    <ul class="profile-menu">
        <li><a href="#"><i class="fas fa-user"></i> My Profile</a></li>
        <li><a href="#"><i class="fas fa-shopping-bag"></i> Orders</a></li>
        <li><a href="#"><i class="fas fa-map-marker-alt"></i> Addresses</a></li>
        <li><a href="#"><i class="fas fa-cog"></i> Settings</a></li>
        <li><a href="#" id="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
    </ul>
</div>
</div>
</div>
</header>

<!-- Hero Section -->
<section class="hero">
    <h1>Discover the Latest Tech Gadgets</h1>
    <p>Explore our premium collection of cutting-edge electronics and accessories designed to enhance your digital lifestyle.</p>
    <button class="cta-button" id="shop-now-btn">Shop Now</button>
</section>

<!-- Categories -->
<div class="categories-container" id="categories-section">
    <div class="categories">
        <div class="category active" onclick="filterProducts('all')">All Products</div>
        <div class="category" onclick="filterProducts('keyboards')">Keyboards</div>
        <div class="category" onclick="filterProducts('mouse')">Mouse</div>
        <div class="category" onclick="filterProducts('monitors')">Monitors</div>
        <div class="category" onclick="filterProducts('laptops')">Laptops</div>
        <div class="category" onclick="filterProducts('smartphones')">Smartphones</div>
    </div>
</div>

<!-- Products Grid -->
<div class="products-grid" id="products-grid">
    <!-- Product 1 -->
    <div class="product-card" data-category="keyboards">
        <img src="https://via.placeholder.com/300x200?text=Mechanical+Keyboard" alt="Mechanical Keyboard" class="product-image">
        <div class="product-details">
            <h3 class="product-name">RGB Mechanical Keyboard</h3>
            <p class="product-description">Premium mechanical keyboard with customizable RGB lighting and ergonomic design.</p>
            <div class="product-rating">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star-half-alt"></i>
                <span>(42)</span>
            </div>
            <div class="product-price">₱2,499.00</div>
            <div class="product-actions">
                <button class="add-to-cart" onclick="addToCart('RGB Mechanical Keyboard', 2499, 'https://via.placeholder.com/300x200?text=Mechanical+Keyboard')">
                    Add to Cart
                </button>
                <button class="wishlist-btn">
                    <i class="far fa-heart"></i>
                </button>
            </div>
        </div>
    </div>
    
    <!-- Product 2 -->
    <div class="product-card" data-category="mouse">
        <img src="https://via.placeholder.com/300x200?text=Gaming+Mouse" alt="Gaming Mouse" class="product-image">
        <div class="product-details">
            <h3 class="product-name">Wireless Gaming Mouse</h3>
            <p class="product-description">High-precision wireless gaming mouse with customizable buttons and RGB lighting.</p>
            <div class="product-rating">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="far fa-star"></i>
                <span>(28)</span>
            </div>
            <div class="product-price">₱1,599.00</div>
            <div class="product-actions">
                <button class="add-to-cart" onclick="addToCart('Wireless Gaming Mouse', 1599, 'https://via.placeholder.com/300x200?text=Gaming+Mouse')">
                    Add to Cart
                </button>
                <button class="wishlist-btn">
                    <i class="far fa-heart"></i>
                </button>
            </div>
        </div>
    </div>
    
    <!-- Product 4 -->
    <div class="product-card" data-category="laptops">
        <img src="https://via.placeholder.com/300x200?text=Gaming+Laptop" alt="Gaming Laptop" class="product-image">
        <div class="product-details">
            <h3 class="product-name">Gaming Laptop Pro</h3>
            <p class="product-description">Powerful gaming laptop with RTX 3060 GPU and high refresh rate display.</p>
            <div class="product-rating">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star-half-alt"></i>
                <span>(34)</span>
            </div>
            <div class="product-price">₱65,999.00</div>
            <div class="product-actions">
                <button class="add-to-cart" onclick="addToCart('Gaming Laptop Pro', 65999, 'https://via.placeholder.com/300x200?text=Gaming+Laptop')">
                    Add to Cart
                </button>
                <button class="wishlist-btn">
                    <i class="far fa-heart"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Cart Sidebar -->
<div class="cart-sidebar" id="cart-sidebar">
    <div class="cart-header">
        <h3 class="cart-title">Your Cart</h3>
        <button class="close-cart" id="close-cart">
            <i class="fas fa-times"></i>
        </button>
    </div>
    <div class="cart-items" id="cart-items">
        <!-- Cart items will be added here dynamically -->
    </div>
    <div class="cart-summary">
        <div class="cart-row">
            <span>Subtotal</span>
            <span id="cart-subtotal">₱0.00</span>
        </div>
        <div class="cart-row">
            <span>Shipping</span>
            <span>₱500.00</span>
        </div>
        <div class="cart-row cart-total">
            <span>Total</span>
            <span id="cart-total">₱0.00</span>
        </div>
        <button class="checkout-btn" id="checkout-btn">Proceed to Checkout</button>
    </div>
</div>

<!-- Checkout Modal -->
<div class="checkout-modal" id="checkout-modal">
    <div class="checkout-container">
        <div class="checkout-header">
            <h2 class="checkout-title">Checkout</h2>
            <div class="checkout-steps">
                <div class="checkout-step">
                    <div class="step-number active">1</div>
                    <div class="step-name">Shipping</div>
                </div>
                <div class="checkout-step">
                    <div class="step-number">2</div>
                    <div class="step-name">Payment</div>
                </div>
                <div class="checkout-step">
                    <div class="step-number">3</div>
                    <div class="step-name">Review</div>
                </div>
            </div>
        </div>

        <div class="checkout-grid">
            <div>
                <div class="checkout-section" id="shipping-section">
                    <h3 class="section-title"><i class="fas fa-truck"></i> Shipping Information</h3>
                    <div class="form-group">
                        <label class="form-label">Full Name</label>
                        <input type="text" class="form-input" placeholder="Enter your full name">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-input" placeholder="Enter your email">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Phone Number</label>
                        <input type="tel" class="form-input" placeholder="Enter your phone number">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Address</label>
                        <input type="text" class="form-input" placeholder="Street address">
                    </div>
                    <div class="form-group">
                        <label class="form-label">City</label>
                        <input type="text" class="form-input" placeholder="Enter your city">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Postal Code</label>
                        <input type="text" class="form-input" placeholder="Enter postal code">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Country</label>
                        <select class="form-input">
                            <option>Philippines</option>
                            <option>United States</option>
                            <option>Canada</option>
                            <option>United Kingdom</option>
                        </select>
                    </div>
                    <div class="checkout-actions">
                        <button class="back-btn" id="back-to-cart"><i class="fas fa-arrow-left"></i> Back to Cart</button>
                        <button class="continue-btn" id="continue-to-payment">Continue to Payment <i class="fas fa-arrow-right"></i></button>
                    </div>
                </div>

                <div class="checkout-section" id="payment-section" style="display: none;">
                    <h3 class="section-title"><i class="fas fa-credit-card"></i> Payment Method</h3>
                    <div class="payment-methods">
                        <div class="payment-method active">
                            <div class="payment-icon">
                                <i class="fab fa-cc-visa"></i>
                            </div>
                            <div class="payment-name">Credit/Debit Card</div>
                        </div>
                        <div class="payment-method">
                            <div class="payment-icon">
                                <i class="fas fa-money-bill-wave"></i>
                            </div>
                            <div class="payment-name">Cash on Delivery</div>
                        </div>
                        <div class="payment-method">
                            <div class="payment-icon">
                                <i class="fab fa-paypal"></i>
                            </div>
                            <div class="payment-name">PayPal</div>
                        </div>
                        <div class="payment-method">
                            <div class="payment-icon">
                                <i class="fas fa-university"></i>
                            </div>
                            <div class="payment-name">Bank Transfer</div>
                        </div>
                    </div>
                    <div class="checkout-actions">
                        <button class="back-btn" id="back-to-shipping"><i class="fas fa-arrow-left"></i> Back to Shipping</button>
                        <button class="continue-btn" id="continue-to-review">Continue to Review <i class="fas fa-arrow-right"></i></button>
                    </div>
                </div>

                <div class="checkout-section" id="review-section" style="display: none;">
                    <h3 class="section-title"><i class="fas fa-check-circle"></i> Review Your Order</h3>
                    <div class="form-group">
                        <label class="form-label">Shipping Address</label>
                        <div class="form-input" style="background: rgba(23, 42, 69, 0.3);">
                            John Doe<br>
                            123 Tech Street<br>
                            Makati City, 1200<br>
                            Philippines
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Payment Method</label>
                        <div class="form-input" style="background: rgba(23, 42, 69, 0.3);">
                            <i class="fab fa-cc-visa"></i> Visa ending in 4242
                        </div>
                    </div>
                    <div class="checkout-actions">
                        <button class="back-btn" id="back-to-payment"><i class="fas fa-arrow-left"></i> Back to Payment</button>
                        <button class="continue-btn" id="place-order">Place Order <i class="fas fa-check"></i></button>
                    </div>
                </div>
            </div>

            <div class="order-summary">
                <h3 class="summary-title">Order Summary</h3>
                <div class="summary-items" id="order-summary-items">
                    <!-- Order items will be added here dynamically -->
                </div>
                <div class="cart-row">
                    <span>Subtotal</span>
                    <span id="order-subtotal">₱0.00</span>
                </div>
                <div class="cart-row">
                    <span>Shipping</span>
                    <span>₱500.00</span>
                </div>
                <div class="summary-total">
                    <span>Total</span>
                    <span id="order-total">₱0.00</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Order Confirmation -->
<div class="order-confirmation" id="order-confirmation">
    <div class="confirmation-icon">
        <i class="fas fa-check-circle"></i>
    </div>
    <h2 class="confirmation-title">Order Confirmed!</h2>
    <p class="confirmation-text">
        Thank you for your purchase! Your order has been received and is being processed.<br>
        We've sent a confirmation email to <strong>john.doe@example.com</strong> with your order details.
    </p>
    <div class="order-details">
        <div class="order-row">
            <span class="order-label">Order Number:</span>
            <span class="order-value">#NG-2023-00142</span>
        </div>
        <div class="order-row">
            <span class="order-label">Date:</span>
            <span class="order-value">October 15, 2023</span>
        </div>
        <div class="order-row">
            <span class="order-label">Total:</span>
            <span class="order-value">₱3,998.00</span>
        </div>
        <div class="order-row">
            <span class="order-label">Payment Method:</span>
            <span class="order-value">Visa ending in 4242</span>
        </div>
        <div class="order-row">
            <span class="order-label">Delivery Address:</span>
            <span class="order-value">123 Tech Street, Makati City, Philippines</span>
        </div>
        <div class="order-row">
            <span class="order-label">Estimated Delivery:</span>
            <span class="order-value">October 18-20, 2023</span>
        </div>
    </div>
    <div>
        <!-- <button class="print-btn" id="print-receipt"><i class="fas fa-print"></i> Print Receipt</button> -->
        <button class="track-btn" id="track-order"><i class="fas fa-map-marker-alt"></i> Track Order</button>
    </div>
</div>

<!-- Delivery Tracking -->
<div class="tracking-container" id="tracking-container">
    <div class="tracking-header">
        <h2 class="tracking-title">Order Tracking</h2>
        <p>Track your order #NG-2023-00142</p>
    </div>
    <div class="tracking-steps">
        <div class="tracking-line"></div>
        <div class="tracking-line-progress"></div>
        
        <div class="tracking-step">
            <div class="step-icon active">
                <i class="fas fa-check"></i>
            </div>
            <div class="step-details">
                <h3 class="step-title">Order Placed</h3>
                <p class="step-description">Your order has been received and is being processed.</p>
                <p class="step-date">October 15, 2023 - 10:30 AM</p>
            </div>
        </div>
        
        <div class="tracking-step">
            <div class="step-icon active">
                <i class="fas fa-check"></i>
            </div>
            <div class="step-details">
                <h3 class="step-title">Payment Confirmed</h3>
                <p class="step-description">Your payment has been successfully processed.</p>
                <p class="step-date">October 15, 2023 - 11:15 AM</p>
            </div>
        </div>
        
        <div class="tracking-step">
            <div class="step-icon active">
                <i class="fas fa-box"></i>
            </div>
            <div class="step-details">
                <h3 class="step-title">Order Processed</h3>
                <p class="step-description">Your items have been packed and are ready for shipping.</p>
                <p class="step-date">October 16, 2023 - 9:00 AM</p>
            </div>
        </div>
        
        <div class="tracking-step">
            <div class="step-icon">
                <i class="fas fa-shipping-fast"></i>
            </div>
            <div class="step-details">
                <h3 class="step-title">Shipped</h3>
                <p class="step-description">Your order is on its way to you.</p>
                <p class="step-date">Estimated: October 17, 2023</p>
            </div>
        </div>
        
        <div class="tracking-step">
            <div class="step-icon">
                <i class="fas fa-home"></i>
            </div>
            <div class="step-details">
                <h3 class="step-title">Delivered</h3>
                <p class="step-description">Your order has been delivered.</p>
                <p class="step-date">Estimated: October 18-20, 2023</p>
            </div>
        </div>
    </div>
    
    <div class="tracking-map">
        <i class="fas fa-map-marked-alt" style="font-size: 40px;"></i>
        <p style="margin-left: 15px;">Live delivery tracking will be available once your order is shipped</p>
    </div>
    
    <div class="tracking-actions">
        <button class="back-btn" id="back-to-orders"><i class="fas fa-arrow-left"></i> Back to Orders</button>
    </div>
</div>

<div class="overlay" id="overlay"></div>

<!-- Add to Cart Notification -->
<div class="add-to-cart-notification" id="add-to-cart-notification">
    <i class="fas fa-check-circle"></i>
    <span>Item added to cart!</span>
</div>

<!-- Order Placed Modal -->
<div id="order-placed-modal" style="display:none; position:fixed; z-index:2000; left:0; top:0; width:100vw; height:100vh; background:rgba(0,0,0,0.7); align-items:center; justify-content:center;">
    <div style="background:#172a45; color:#fff; border-radius:15px; padding:40px 30px; max-width:350px; margin:auto; text-align:center; box-shadow:0 8px 32px rgba(0,0,0,0.3);">
        <div style="font-size:60px; color:#4ade80; margin-bottom:15px;">
            <i class="fas fa-check-circle"></i>
        </div>
        <h2 style="color:#6366f1; margin-bottom:10px;">Order Placed!</h2>
        <p style="font-size:16px; margin-bottom:25px;">
            Thank you for your order.<br>
            You will receive a confirmation email shortly.
        </p>
        <button id="close-order-placed-modal" style="padding:10px 30px; border-radius:5px; background:#6366f1; color:#fff; border:none; font-weight:bold; cursor:pointer;">
            OK
        </button>
    </div>
</div>

<!-- Footer -->
<footer class="footer">
    <div class="footer-content">
        <div class="footer-column">
            <h3>Shop</h3>
            <ul>
                <li><a href="#">All Products</a></li>
                <li><a href="#">Featured</a></li>
                <li><a href="#">New Arrivals</a></li>
                <li><a href="#">Deals</a></li>
            </ul>
        </div>
        <div class="footer-column">
            <h3>Support</h3>
            <ul>
                <li><a href="#">Contact Us</a></li>
                <li><a href="#">FAQs</a></li>
                <li><a href="#">Shipping</a></li>
                <li><a href="#">Returns</a></li>
            </ul>
        </div>
        <div class="footer-column">
            <h3>About</h3>
            <ul>
                <li><a href="#">Our Story</a></li>
                <li><a href="#">Careers</a></li>
                <li><a href="#">Blog</a></li>
                <li><a href="#">Press</a></li>
            </ul>
        </div>
        <div class="footer-column">
            <h3>Connect</h3>
            <div class="social-links">
                <a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                <a href="#" class="social-link"><i class="fab fa-youtube"></i></a>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <p>&copy; 2023 NexusGadgets. All rights reserved.</p>
    </div>
</footer>

<script>
    // Cart functionality
    let cart = [];
    let cartTotal = 0;
    
    // DOM elements
    const cartIcon = document.getElementById('cart-icon');
    const cartSidebar = document.getElementById('cart-sidebar');
    const closeCart = document.getElementById('close-cart');
    const overlay = document.getElementById('overlay');
    const cartItemsContainer = document.getElementById('cart-items');
    const cartSubtotal = document.getElementById('cart-subtotal');
    const cartTotalElement = document.getElementById('cart-total');
    const cartCount = document.getElementById('cart-count');
    const addToCartNotification = document.getElementById('add-to-cart-notification');
    const shopNowBtn = document.getElementById('shop-now-btn');
    const shopLink = document.getElementById('shop-link');
    const checkoutBtn = document.getElementById('checkout-btn');
    const checkoutModal = document.getElementById('checkout-modal');
    const backToCartBtn = document.getElementById('back-to-cart');
    const continueToPaymentBtn = document.getElementById('continue-to-payment');
    const backToShippingBtn = document.getElementById('back-to-shipping');
    const continueToReviewBtn = document.getElementById('continue-to-review');
    const backToPaymentBtn = document.getElementById('back-to-payment');
    const placeOrderBtn = document.getElementById('place-order');
    const orderConfirmation = document.getElementById('order-confirmation');
    const trackOrderBtn = document.getElementById('track-order');
    const trackingContainer = document.getElementById('tracking-container');
    const backToOrdersBtn = document.getElementById('back-to-orders');
    const shippingSection = document.getElementById('shipping-section');
    const paymentSection = document.getElementById('payment-section');
    const reviewSection = document.getElementById('review-section');
    const orderSummaryItems = document.getElementById('order-summary-items');
    const orderSubtotal = document.getElementById('order-subtotal');
    const orderTotal = document.getElementById('order-total');
    const profileIcon = document.getElementById('profile-icon');
    const profileDropdown = document.getElementById('profile-dropdown');
    const logoutBtn = document.getElementById('logout-btn');
    
    // Toggle cart sidebar
    cartIcon.addEventListener('click', () => {
        cartSidebar.classList.add('open');
        overlay.classList.add('active');
    });
    
    closeCart.addEventListener('click', () => {
        cartSidebar.classList.remove('open');
        overlay.classList.remove('active');
    });
    
    overlay.addEventListener('click', () => {
        cartSidebar.classList.remove('open');
        checkoutModal.classList.remove('active');
        overlay.classList.remove('active');
        profileDropdown.classList.remove('active');
    });
    
    // Toggle profile dropdown
    profileIcon.addEventListener('click', (e) => {
        e.stopPropagation();
        profileDropdown.classList.toggle('active');
    });
    
    // Close profile dropdown when clicking outside
    document.addEventListener('click', (e) => {
        if (!profileIcon.contains(e.target) && !profileDropdown.contains(e.target)) {
            profileDropdown.classList.remove('active');
        }
    });
    
    // Logout functionality
    logoutBtn.addEventListener('click', (e) => {
        e.preventDefault();
        alert('You have been logged out successfully.');
        profileDropdown.classList.remove('active');
    });
    
    // Add to cart function
    function addToCart(name, price, image) {
        // Check if item already exists in cart
        const existingItem = cart.find(item => item.name === name);
        
        if (existingItem) {
            existingItem.quantity += 1;
        } else {
            cart.push({
                name,
                price,
                image,
                quantity: 1
            });
        }
        
        // Update cart total
        cartTotal += price;
        
        // Update UI
        updateCartUI();
        
        // Show notification
        showAddToCartNotification();
    }
    
    // Update cart UI
    function updateCartUI() {
        // Clear cart items
        cartItemsContainer.innerHTML = '';
        orderSummaryItems.innerHTML = '';
        
        // Add each item to cart
        cart.forEach(item => {
            const cartItemElement = document.createElement('div');
            cartItemElement.className = 'cart-item';
            cartItemElement.innerHTML = `
                <div class="cart-item-info">
                    <img src="${item.image}" alt="${item.name}" class="cart-item-image">
                    <div class="cart-item-details">
                        <h4 class="cart-item-name">${item.name}</h4>
                        <span class="cart-item-price">₱${item.price.toLocaleString()}</span>
                    </div>
                </div>
                <div class="cart-item-controls">
                    <button class="qty-btn" onclick="updateQuantity('${item.name}', -1)">-</button>
                    <span class="cart-item-qty">${item.quantity}</span>
                    <button class="qty-btn" onclick="updateQuantity('${item.name}', 1)">+</button>
                    <button class="remove-btn" onclick="removeFromCart('${item.name}')">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            `;
            cartItemsContainer.appendChild(cartItemElement);
            
            // Add to order summary
            const summaryItem = document.createElement('div');
            summaryItem.className = 'summary-item';
            summaryItem.innerHTML = `
                <div class="item-name">${item.name} × ${item.quantity}</div>
                <div class="item-price">₱${(item.price * item.quantity).toLocaleString()}</div>
            `;
            orderSummaryItems.appendChild(summaryItem);
        });
        
        // Update totals
        const subtotal = cartTotal;
        const total = subtotal + 500; // Add shipping
        cartSubtotal.textContent = `₱${subtotal.toLocaleString()}`;
        cartTotalElement.textContent = `₱${total.toLocaleString()}`;
        orderSubtotal.textContent = `₱${subtotal.toLocaleString()}`;
        orderTotal.textContent = `₱${total.toLocaleString()}`;
        
        // Update cart count
        const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
        cartCount.textContent = totalItems;

        // Disable checkout if cart is empty
        checkoutBtn.disabled = cart.length === 0;
    }

    // Update quantity of cart item
    function updateQuantity(name, change) {
        const item = cart.find(item => item.name === name);
        if (!item) return;
        if (item.quantity + change <= 0) {
            removeFromCart(name);
        } else {
            item.quantity += change;
            cartTotal += item.price * change;
            updateCartUI();
        }
    }

    // Remove item from cart
    function removeFromCart(name) {
        const index = cart.findIndex(item => item.name === name);
        if (index !== -1) {
            cartTotal -= cart[index].price * cart[index].quantity;
            cart.splice(index, 1);
            updateCartUI();
        }
    }

    // Show add to cart notification
    function showAddToCartNotification() {
        addToCartNotification.classList.add('show');
        setTimeout(() => {
            addToCartNotification.classList.remove('show');
        }, 1500);
    }

    // Filter products by category
    function filterProducts(category) {
        const productCards = document.querySelectorAll('.product-card');
        document.querySelectorAll('.category').forEach(cat => cat.classList.remove('active'));
        if (category === 'all') {
            productCards.forEach(card => card.style.display = 'block');
            document.querySelector('.category[onclick*="all"]').classList.add('active');
        } else {
            productCards.forEach(card => {
                if (card.getAttribute('data-category') === category) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
            document.querySelector(`.category[onclick*="${category}"]`).classList.add('active');
        }
    }

   

    // Scroll to shop section
    shopNowBtn.addEventListener('click', () => {
        document.getElementById('categories-section').scrollIntoView({ behavior: 'smooth' });
    });
    shopLink.addEventListener('click', (e) => {
        e.preventDefault();
        document.getElementById('categories-section').scrollIntoView({ behavior: 'smooth' });
    });

    // Checkout modal navigation
    checkoutBtn.addEventListener('click', () => {
        checkoutModal.classList.add('active');
        overlay.classList.add('active');
        shippingSection.style.display = '';
        paymentSection.style.display = 'none';
        reviewSection.style.display = 'none';
    });

    backToCartBtn.addEventListener('click', () => {
        checkoutModal.classList.remove('active');
        overlay.classList.remove('active');
    });

    continueToPaymentBtn.addEventListener('click', () => {
        shippingSection.style.display = 'none';
        paymentSection.style.display = '';
        reviewSection.style.display = 'none';
        setCheckoutStep(2);
    });

    backToShippingBtn.addEventListener('click', () => {
        shippingSection.style.display = '';
        paymentSection.style.display = 'none';
        reviewSection.style.display = 'none';
        setCheckoutStep(1);
    });

    continueToReviewBtn.addEventListener('click', () => {
        shippingSection.style.display = 'none';
        paymentSection.style.display = 'none';
               reviewSection.style.display = '';
        updateReviewSection();
        setCheckoutStep(3);
    });

    backToPaymentBtn.addEventListener('click', () => {
        shippingSection.style.display = 'none';
        paymentSection.style.display = '';
        reviewSection.style.display = 'none';
        setCheckoutStep(2);
    });

    // Place order
    placeOrderBtn.addEventListener('click', () => {
        checkoutModal.classList.remove('active');
        overlay.classList.remove('active');
        // Show modal
        document.getElementById('order-placed-modal').style.display = 'flex';
        // Reset cart
        cart = [];
        cartTotal = 0;
        updateCartUI();
    });

    // Track order
    trackOrderBtn.addEventListener('click', () => {
        orderConfirmation.style.display = 'none';
        trackingContainer.style.display = 'block';
    });

    backToOrdersBtn.addEventListener('click', () => {
        trackingContainer.style.display = 'none';
        orderConfirmation.style.display = 'block';
    });

    // Close Order Placed Modal and show order confirmation section
    document.getElementById('close-order-placed-modal').addEventListener('click', () => {
        document.getElementById('order-placed-modal').style.display = 'none';
        orderConfirmation.style.display = 'block';
    });

    // Set checkout step UI
    function setCheckoutStep(step) {
        const steps = document.querySelectorAll('.checkout-step .step-number');
        steps.forEach((el, idx) => {
            if (idx === step - 1) {
                el.classList.add('active');
            } else {
                el.classList.remove('active');
            }
        });
    }

    // --- Payment Method Selection ---
    let selectedPaymentMethod = 'Credit/Debit Card';

    // Payment method selection logic
    document.querySelectorAll('.payment-method').forEach(method => {
        method.addEventListener('click', function () {
            document.querySelectorAll('.payment-method').forEach(m => m.classList.remove('active'));
            this.classList.add('active');
            selectedPaymentMethod = this.querySelector('.payment-name').textContent.trim();
        });
    });

    // --- Shipping Info State ---
    let shippingInfo = {
        name: '',
        email: '',
        phone: '',
        address: '',
        city: '',
        postal: '',
        country: 'Philippines'
    };

    // Save shipping info on continue to payment
    continueToPaymentBtn.addEventListener('click', () => {
        // Get values from shipping form
        const shippingInputs = shippingSection.querySelectorAll('.form-input');
        shippingInfo.name = shippingInputs[0].value;
        shippingInfo.email = shippingInputs[1].value;
        shippingInfo.phone = shippingInputs[2].value;
        shippingInfo.address = shippingInputs[3].value;
        shippingInfo.city = shippingInputs[4].value;
        shippingInfo.postal = shippingInputs[5].value;
        shippingInfo.country = shippingInputs[6].value;

        // Simple validation (optional)
        if (!shippingInfo.name || !shippingInfo.email || !shippingInfo.phone || !shippingInfo.address || !shippingInfo.city || !shippingInfo.postal) {
            alert('Please fill in all shipping fields.');
            return;
        }

        shippingSection.style.display = 'none';
        paymentSection.style.display = '';
        reviewSection.style.display = 'none';
        setCheckoutStep(2);
    });

    // --- Review Section Update ---
    function updateReviewSection() {
        // Shipping Address
        reviewSection.querySelectorAll('.form-input')[0].innerHTML = `
            ${shippingInfo.name}<br>
            ${shippingInfo.address}<br>
            ${shippingInfo.city}, ${shippingInfo.postal}<br>
            ${shippingInfo.country}
        `;
        // Payment Method
        reviewSection.querySelectorAll('.form-input')[1].innerHTML = `
            ${selectedPaymentMethod === 'Credit/Debit Card' ? '<i class="fab fa-cc-visa"></i> Credit/Debit Card' : ''}
            ${selectedPaymentMethod === 'Cash on Delivery' ? '<i class="fas fa-money-bill-wave"></i> Cash on Delivery' : ''}
            ${selectedPaymentMethod === 'PayPal' ? '<i class="fab fa-paypal"></i> PayPal' : ''}
            ${selectedPaymentMethod === 'Bank Transfer' ? '<i class="fas fa-university"></i> Bank Transfer' : ''}
        `;
    }

    continueToReviewBtn.addEventListener('click', () => {
        shippingSection.style.display = 'none';
        paymentSection.style.display = 'none';
        reviewSection.style.display = '';
        updateReviewSection();
        setCheckoutStep(3);
    });

    backToPaymentBtn.addEventListener('click', () => {
        shippingSection.style.display = 'none';
        paymentSection.style.display = '';
        reviewSection.style.display = 'none';
        setCheckoutStep(2);
    });

    // Initialize UI on load
    updateCartUI();
    orderConfirmation.style.display = 'none';
    trackingContainer.style.display = 'none';

</script>
</body>
</html>