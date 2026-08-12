<table class="panel" width="100%" cellpadding="0" cellspacing="0" role="presentation">
    <tr>
        <td class="panel-content" style="background: #FAFAF8; border: 1.5px solid #E8E4DE; border-radius: 14px; padding: 1.5rem; margin-bottom: 1.5rem;">
            <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
                <tr>
                    <td class="panel-item" style="font-size: 0.9rem; line-height: 1.65; color: #1B2A4A;">
                        {{ Illuminate\Mail\Markdown::parse($slot) }}
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

