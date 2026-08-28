<style>
    .login-link {
        font-weight: 500;
        text-decoration: none;
        transition: all .3s ease;
    }

    .login-link:hover {
        color: #d4af37 !important;
    }

    .dashboard-link {
        color: #fff !important;
        text-decoration: none;
        border: 1px solid rgba(255, 255, 255, .25);
        background: rgba(255, 255, 255, .08);
        backdrop-filter: blur(10px);
        transition: all .3s ease;
    }

    .dashboard-link:hover {
        background: rgba(212, 175, 55, .15);
        border-color: #d4af37;
        color: #d4af37 !important;
    }

    .btn-gold {
        color: #fff !important;
        text-decoration: none;
        font-weight: 600;
        background: linear-gradient(135deg, #b8860b, #d4af37, #f1d77a);
        box-shadow: 0 8px 25px rgba(212, 175, 55, .25);
        transition: all .3s ease;
    }

    .btn-gold:hover {
        color: #fff !important;
        transform: translateY(-2px);
        box-shadow: 0 12px 30px rgba(212, 175, 55, .4);
    }

    .btn-gold i {
        transition: transform .3s ease;
    }

    .btn-gold:hover i {
        transform: translateX(4px);
    }

    @media (max-width: 991px) {
        .navbar-collapse {
            background: rgba(27, 42, 74, 0.98);
            backdrop-filter: blur(20px);
            border-radius: var(--radius-lg);
            padding: 1.5rem;
            margin-top: 1rem;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(198, 169, 98, 0.2);
        }

        .navbar-nav {
            gap: 0.5rem;
        }

        .nav-link {
            padding: 0.75rem 1rem !important;
            border-radius: var(--radius);
            text-align: center;
            color: rgba(255, 255, 255, 0.9) !important;
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            background: rgba(198, 169, 98, 0.15);
            color: var(--gold-light) !important;
        }

        .navbar .d-flex {
            flex-direction: column;
            gap: 0.75rem;
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px solid rgba(198, 169, 98, 0.2);
        }

        .navbar .d-flex .nav-link,
        .navbar .d-flex .btn-gold {
            width: 100%;
            justify-content: center;
            text-align: center;
        }

        .navbar .d-flex .login-link {
            text-align: center;
            padding: 0.75rem 1rem;
            border-radius: var(--radius);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .navbar .d-flex .login-link:hover {
            background: rgba(198, 169, 98, 0.15);
            border-color: var(--gold);
        }
    }

    .wa-float {
        position: fixed;
        bottom: 24px;
        right: 24px;
        z-index: 9999;
        display: flex;
        align-items: center;
        gap: 10px;
        background: #25D366;
        color: #fff;
        padding: 12px 20px 12px 16px;
        border-radius: 50px;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.9rem;
        box-shadow: 0 8px 30px rgba(37, 211, 102, 0.4);
        transition: all 0.3s cubic-bezier(0.25, 1, 0.5, 1);
        overflow: visible;
    }

    .wa-float:hover {
        transform: translateY(-3px) scale(1.05);
        box-shadow: 0 12px 40px rgba(37, 211, 102, 0.5);
        color: #fff;
    }

    .wa-float__icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        font-size: 1.4rem;
        flex-shrink: 0;
    }

    .wa-float__text {
        white-space: nowrap;
    }

    .wa-float__pulse {
        position: absolute;
        top: -4px;
        right: -4px;
        width: 16px;
        height: 16px;
        background: #ff4444;
        border-radius: 50%;
        border: 2px solid #fff;
        animation: waPulse 2s infinite;
    }

    @keyframes waPulse {
        0% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.3); opacity: 0.7; }
        100% { transform: scale(1); opacity: 1; }
    }

    @media (max-width: 768px) {
        .wa-float {
            bottom: 16px;
            right: 16px;
            padding: 10px 16px 10px 14px;
            font-size: 0.85rem;
        }

        .wa-float__icon {
            width: 28px;
            height: 28px;
            font-size: 1.2rem;
        }
    }
</style>
