<?php

namespace Tests\Feature;

use App\Models\Feedback;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactFormTest extends TestCase
{
    use RefreshDatabase;

    public function test_contact_page_loads(): void
    {
        $this->get(route('contact.index'))->assertOk();
    }

    public function test_valid_submission_is_stored_and_redirects(): void
    {
        $payload = [
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'phone' => '08123456789',
            'subject' => 'Pertanyaan',
            'message' => 'Apakah puskesmas buka hari Sabtu?',
        ];

        $response = $this->post(route('contact.store'), $payload);

        $response->assertRedirect(route('contact.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('feedback', [
            'email' => 'budi@example.com',
            'name' => 'Budi Santoso',
        ]);
    }

    public function test_submission_requires_mandatory_fields(): void
    {
        $response = $this->post(route('contact.store'), []);

        $response->assertSessionHasErrors(['name', 'email', 'message']);
        $this->assertDatabaseCount('feedback', 0);
    }

    public function test_email_must_be_valid(): void
    {
        $response = $this->post(route('contact.store'), [
            'name' => 'Budi',
            'email' => 'bukan-email',
            'message' => 'Halo',
        ]);

        $response->assertSessionHasErrors('email');
    }

    public function test_feedback_factory_creates_record(): void
    {
        $feedback = Feedback::factory()->create();

        $this->assertDatabaseHas('feedback', ['id' => $feedback->id]);
        $this->assertFalse($feedback->is_read);
    }
}
