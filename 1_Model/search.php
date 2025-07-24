<?php
require_once __DIR__ . '/../vendor/autoload.php';
use Dotenv\Dotenv;

/**
* @param string $search_input :: input user value  
* @param int $counter_start :: first result of the page (0, 15, 30, 45, ...) 
* @param int $counter_end :: +15 (incrementation) of the first result
* @param int $content_type :: the type of result (picture, clip, website, others)
* @param int $content :: returned HTML content result
*
* @return void|mixed Return type or description (adjust as needed).
**/

class Content {
    private string $search_input;
    public int $counter_start;
    private int $counter_end;
    private string $content_type;
    public string $content = '';
    public int $dataSize = 0;

    public function __construct(string $search_input, string $content_type, int $counter_start, int $counter_end) {
        $this->search_input = $search_input;
        $this->content_type = $content_type;
        $this->counter_start = $counter_start;
        $this->counter_end = $counter_end;
    }

    public function fetchContent(): void {
        $dotenv = Dotenv::createImmutable(realpath(__DIR__ . '/../'));
        $dotenv->load();
        $search_key = $_ENV['SEARCH_KEY'];
        $pixabay_key = $_ENV['PIXABAY_KEY'];
        $query = urldecode($this->search_input);

        $urlData = [
            'website' => "https://serpapi.com/search.json?q={$query}&api_key={$search_key}",
            'picture' => "https://pixabay.com/api/?key={$pixabay_key}&q={$query}&image_type=photo",
            'clip' => "https://pixabay.com/api/videos/?key={$pixabay_key}&q={$query}",
        ];

        if (!isset($urlData[$this->content_type])) {
            $this->content = 'Invalid content type.';
            return;
        }

        $response = file_get_contents($urlData[$this->content_type]);
        $data = json_decode($response, true);
        $dataSize = sizeof($data['hits'] ?? $data['organic_results']);
        $this->dataSize = $dataSize;

        for ($i = $this->counter_start; $i < $this->counter_end; $i++) {
            if ($this->content_type === 'website') {
                $item = $data['organic_results'][$i] ?? null;
                if ($item) {
                    $this->content .= '<div class="result_container"><small class="path">' . htmlspecialchars($item['displayed_link']) . '</small>
                    <div class="title_container">
                        <img src="' . htmlspecialchars($item['favicon'] ?? '') . '" height="20px" alt="">
                        <a class="title" target="_blank" href="' . htmlspecialchars($item['link']) . '">' . htmlspecialchars($item['title']) . '</a>
                        <img src="../public/img/verif.png" title="vérifier" height="20px" alt="">
                    </div>
                    <p class="description">' . htmlspecialchars($item['snippet']) . '</p></div>';
                }
            } else {
                $media = $this->content_type === 'clip'
                    ? ($data['hits'][$i]['videos']['medium']['url'] ?? null)
                    : ($data['hits'][$i]['webformatURL'] ?? null);

                if ($media && $this->content_type === 'picture') {
                    $this->content .= '<a href="' . htmlspecialchars($media) . '" target="_blank"><img src="' . htmlspecialchars($media) . '" width="100%" alt=""></a>';
                } elseif($media && $this->content_type === 'clip'){
                    $this->content .= '<video width="320" height="240" controls>
                                            <source src="' . htmlspecialchars($media) .'" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>';
                }
            }
        }
    }
}
?>