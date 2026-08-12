@props([
    'url',
    'color' => 'primary',
    'align' => 'center',
])
<table class="action" align="{{ $align }}" width="100%" cellpadding="0" cellspacing="0" role="presentation">
    <tr>
        <td align="{{ $align }}">
            <table width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation">
                <tr>
                    <td align="{{ $align }}">
                        <table border="0" cellpadding="0" cellspacing="0" role="presentation">
                            <tr>
                                <td>
                                    <a href="{{ $url }}" class="button" target="_blank" rel="noopener" style="display: inline-block; background: linear-gradient(135deg, #1B2A4A 0%, #2C3E5F 100%); color: #FFFFFF !important; border-radius: 14px; font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif; font-size: 0.9rem; font-weight: 600; text-decoration: none; line-height: 52px; height: 52px; padding: 0 24px;">{!! $slot !!}</a>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
