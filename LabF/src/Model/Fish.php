<?php
namespace App\Model;

use App\Service\Config;

class Fish
{
    private ?int $id = null;
    private ?string $species = null;
    private ?string $location = null;
    private ?string $record = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): Fish
    {
        $this->id = $id;
        return $this;
    }

    public function getSpecies(): ?string
    {
        return $this->species;
    }

    public function setSpecies(?string $species): Fish
    {
        $this->species = $species;
        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(?string $location): Fish
    {
        $this->location = $location;
        return $this;
    }

    public function getRecord(): ?string
    {
        return $this->record;
    }

    public function setRecord(?string $record): Fish
    {
        $this->record = $record;
        return $this;
    }

    public static function fromArray($array): Fish
    {
        $fish = new self();
        $fish->fill($array);
        return $fish;
    }

    public function fill($array): Fish
    {
        if (isset($array['id']) && !$this->getId()) {
            $this->setId($array['id']);
        }
        if (isset($array['species'])) {
            $this->setSpecies($array['species']);
        }
        if (isset($array['location'])) {
            $this->setLocation($array['location']);
        }
        if (isset($array['record'])) {
            $this->setRecord($array['record']);
        }
        return $this;
    }

    public static function findAll(): array
    {
        $pdo = new \PDO(Config::get('db_dsn'), Config::get('db_user'), Config::get('db_pass'));
        $sql = 'SELECT * FROM fish';
        $statement = $pdo->prepare($sql);
        $statement->execute();

        $fishes = [];
        $fishesArray = $statement->fetchAll(\PDO::FETCH_ASSOC);
        foreach ($fishesArray as $fishArray) {
            $fishes[] = self::fromArray($fishArray);
        }

        return $fishes;
    }

    public static function find($id): ?Fish
    {
        $pdo = new \PDO(Config::get('db_dsn'), Config::get('db_user'), Config::get('db_pass'));
        $sql = 'SELECT * FROM fish WHERE id = :id';
        $statement = $pdo->prepare($sql);
        $statement->execute(['id' => $id]);

        $fishArray = $statement->fetch(\PDO::FETCH_ASSOC);
        if (!$fishArray) {
            return null;
        }
        return Fish::fromArray($fishArray);
    }

    public function save(): void
    {
        $pdo = new \PDO(Config::get('db_dsn'), Config::get('db_user'), Config::get('db_pass'));
        if (!$this->getId()) {
            $sql = "INSERT INTO fish (species, location, record) VALUES (:species, :location, :record)";
            $statement = $pdo->prepare($sql);
            $statement->execute([
                'species' => $this->getSpecies(),
                'location' => $this->getLocation(),
                'record' => $this->getRecord(),
            ]);
            $this->setId($pdo->lastInsertId());
        } else {
            $sql = "UPDATE fish SET species = :species, location = :location, record = :record WHERE id = :id";
            $statement = $pdo->prepare($sql);
            $statement->execute([
                ':species' => $this->getSpecies(),
                ':location' => $this->getLocation(),
                ':record' => $this->getRecord(),
                ':id' => $this->getId(),
            ]);
        }
    }

    public function delete(): void
    {
        $pdo = new \PDO(Config::get('db_dsn'), Config::get('db_user'), Config::get('db_pass'));
        $sql = "DELETE FROM fish WHERE id = :id";
        $statement = $pdo->prepare($sql);
        $statement->execute([
            ':id' => $this->getId(),
        ]);

        $this->setId(null);
        $this->setSpecies(null);
        $this->setLocation(null);
        $this->setRecord(null);
    }
}
