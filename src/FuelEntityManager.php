<?php declare(strict_types=1);
/*
    Copyright (c) 2020 Sebastian Twaróg <contact@stwarog.com>

    Permission is hereby granted, free of charge, to any person obtaining
    a copy of this software and associated documentation files (the
    "Software"), to deal in the Software without restriction, including
    without limitation the rights to use, copy, modify, merge, publish,
    distribute, sublicense, and/or sell copies of the Software, and to
    permit persons to whom the Software is furnished to do so, subject to
    the following conditions:

    The above copyright notice and this permission notice shall be
    included in all copies or substantial portions of the Software.

    THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
    EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
    MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
    NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
    LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
    OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
    WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
*/

namespace Stwarog\UowFuel;


use Exception;
use Fuel\Core\DB;
use Orm\Model;
use Stwarog\Uow\EntityManager;
use Stwarog\Uow\EntityManagerInterface;
use Stwarog\Uow\UnitOfWork\UnitOfWork;

class FuelEntityManager extends EntityManager implements EntityManagerInterface
{
    /**
     * Initializes new instance (Forge in Fuel's nomenclature).
     *
     * @param DB    $db
     * @param array $config
     *
     * @return static
     */
    public static function forge(DB $db, array $config = []): self
    {
        return new self(new FuelDBAdapter($db), new UnitOfWork(), $config);
    }

    /**
     * @param Model $orm
     * @param bool  $flush
     *
     * @throws Exception
     */
    public function save(Model $orm, bool $flush = false): void
    {
        $this->persist(new FuelModelAdapter($orm));
        if ($flush) {
            $this->flush();
        }
    }

    public function delete(Model $orm): void
    {
        $this->remove(new FuelModelAdapter($orm));
    }
}
